<?php
namespace Admin\Backend\Model;

class Settings {
    const DATE_FMT = "Y-m-d";
    const PER_PAGE = 10;
    const SGRS_CTX = "SGRS";
    const NC_CTX = "NC";
    const LIMIT=200;

    public static function getPermissions() {
        // $routeCollection = $this->get('router')
        //                         ->getRouteCollection();
        // foreach ($routeCollection->all() as $routeName => $route) {            
        //     if (strstr($routeName, 'administration_')){
        //         $ary[] = $routeName;
        //     }
        // }
        $ary = [
            // administration
            "ADMINISTRAÇÃO" => [
                [
                    "label" => "Administração",
                    "code" => "ROLE_ADMIN",
                ],
                [
                    "label" => "Gestão de Acesso",
                    "code" => "BACKEND_ADMINISTRATION_MAIN",
                ],
            ],

            // parametrizacao
            "PARAMETRIZAÇÃO" => [
                [
                    "label" => "Departamentos",
                    "code" => "ADMINISTRATION_ENTITIES",
                ],
                [
                    "label" => "Anexos",
                    "code" => "ADMINISTRATION_DOCUMENT",
                ]
            ],

            // nao conformidades
            "GESTÃO DE NÃO CONFORMIDADES" => [
                [
                    "label" => "Controlo de Não Conformidades",
                    "code" => "BACKEND_ADMINISTRATION_NC",
                ],
                [
                    "label" => "Listagem",
                    "code" => "BACKEND_ADMINISTRATION_NC",
                ]
            ],


            "GESTÃO DE ACÇÕES CORRETIVAS E PREVENTIVAS" => [
                [
                    "label" => "Registo",
                    "code" => "ADMINISTRATION_CORRECTION_NEW",
                ],
                [
                    "label" => "Listagem",
                    "code" => "ADMINISTRATION_CORRECTION",
                ],
                [
                    "label" => "Análise das causas",
                    "code" => "ADMINISTRATION_CORRECTION_BYSTATE",
                ],
                [
                    "label" => "Acções a implementar",
                    "code" => "ADMINISTRATION_CORRECTION_BYSTATE",
                ],
                [
                    "label" => "Avaliações da Eficácia",
                    "code" => "ADMINISTRATION_CORRECTION_BYSTATE",
                ],
            ],

            "RELATÓRIO ESTATÍSTICO" => [
                [
                    "label" => "RELATÓRIO ESTATÍSTICO",
                    "code" => "BACKEND_ADMINISTRATION_STATS",
                ],
            ]
        ];
        return $ary;
    }

}
