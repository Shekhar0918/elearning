<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Admin',
                        'action' => 'index',
                    ),
                ),
            ),
            'adminAuth' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/adminAuth',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'adminAuth',
                    ),
                ),
            ),
            'adminPortalLogin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/adminPortalLogin',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'adminPortalLogin',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'logout',
                    ),
                ),
            ),
            'adminPortal' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/adminPortal',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'adminPortal',
                    ),
                ),
            ),
            'getAdminUserInfo' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/getAdminUserInfo',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'getAdminUserInfo',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\AdminController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'admin/admin/index' => __DIR__ . '/../view/admin/admin/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
                'my-first-route' => array(
//                    'type'    => 'simple',       // <- simple route is created by default, we can skip that
                    'options' => array(
                        'route' => 'foo <bar>',
                        'defaults' => array(
                            'controller' => 'Admin\Controller\Index',
                            'action' => 'fooBar'
                        )
                    )
                ),
                'sendMail' => array(
                    'options' => array(
                        'route' => 'sendMail <emailDetails>',
                        'defaults' => array(
                            'controller' => 'Admin\Controller\Index',
                            'action' => 'sendMail'
                        )
                    )
                ),
            ),
        ),
    ),
);
