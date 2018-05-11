<?php
namespace Admin\Backend\Model;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Admin\Backend\Entity\Stage;

class StatsService {
    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function count($em, $model, $opts=[]) {
		$q = 'select 
				count(1) as count,
				date_format(created_at, "%Y-%m") as period
			from ' . $model . ' c
			where c.created_at >= :start and c.created_at <= :end
        ';

		$params = [
			'start'=>$opts['start'],
			'end'=>$opts['end']
		];

		if (@$opts['state']) {
			$q .= ' and state=:state ';
			$params['state']=$opts['state'];
		}

		if (@$opts['type']) {
			$q .= ' and type=:type ';
			$params['type']=$opts['type'];
		}

		return $this->fetchAll($em, $q, $params);
	}

	public function responseAvg($em, $model, $opts=[]) {
		$type = 'type';
		$params = [
			'start'=>$opts['start'],
			'end'=>$opts['end']
		];
		if (@$opts['type']) {
			$type="'".@$opts['type']."'";
		}

		$q = "
			select 
				$type as type,
				a.codigo as code,
				sum(datediff(c.response_date, c.created_at)) / count(1) as count
			from comp_book c
			join app_entity a ON a.id = (
				select entity from user where id=c.created_by
			)
			where c.created_at >= :start and c.created_at <= :end
			and c.response_date is not null
			group by a.id, $type
		";

		if (@$opts['state']) {
			$q .= ' and state=:state ';
			$params['state']=$opts['state'];
		}

		if (@$opts['type']) {
			$q .= ' and type=:type ';
			$params['type']=$opts['type'];
		}

		return $this->fetchAll($em, $q, $params);
	}

	public function groupByMonth($em, $model, $opts=[]) {
		$year = date("Y");
		$type = 'type';

		if (@$opts['type']) {
			$type= "'".$opts['type']."'";
		}

		if (@$opts['year']) {
			$year=(int)@$opts['year'];
		}

		$sql = '
			select COUNT(1) as count
				,DATE_FORMAT(created_at, "%Y-%m") as period
				,'.$type.' as type
			from '. $model .' 
			where year(created_at) = :year
			group by DATE_FORMAT(created_at, "%Y-%m"), type
		';

		$params = ["year" => $year];
		return $this->fetchAll($em, $sql, $params);
	}

	public function groupByDepartment($em, $model, $opts=[]) {
		$type = 'type';

		$params = [
			'start'=>$opts['start'],
			'end'=>$opts['end']
		];

		if (@$opts['type']) {
			$type="'".@$opts['type']."'";
		}

		$sql = '
			select COUNT(1) as count,
				'. $type .' as type, 
				a.codigo as code
			from ' . $model . ' c
			join app_entity a ON a.id = (
				select entity from user where id=c.created_by
			) where c.created_at >= :start and c.created_at <= :end
			group by '.$type.', a.codigo
		';

		return $this->fetchAll($em, $sql, $params);
	}

	private function fetchAll($em, $sql, $params) {
		// TODO research a way to get $em inside services
		//       something like this:
        // $em = $this->container->getDoctrine()->getManager();
		$stmt = $em->getConnection()->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll();
	}
}

