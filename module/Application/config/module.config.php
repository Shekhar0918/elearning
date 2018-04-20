<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'index' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/home',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'login',
                    ),
                ),
            ),
            'auth' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/auth',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'auth',
                    ),
                ),
            ),
            'googleAccessToken' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/googleAccessToken',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'googleAccessToken',
                    ),
                ),
            ),
            'facebookAccessToken' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/facebookAccessToken',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'facebookAccessToken',
                    ),
                ),
            ),
            'getUserInfo' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/getUserInfo',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'getUserInfo',
                    ),
                ),
            ),
//            'signup' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/signup',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'signup',
//                    ),
//                ),
//            ),
            'googleSignup' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/googleSignup',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'googleSignup',
                    ),
                ),
            ),
            'facebookSignup' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/facebookSignup',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'facebookSignup',
                    ),
                ),
            ),
            'userSignUp' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/userSignUp',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'userSignUp',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'logout',
                    ),
                ),
            ),
            'getEnrolledPrograms' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/getEnrolledPrograms',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'getEnrolledPrograms',
                    ),
                ),
            ),
            'getProgramList' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/getProgramList',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'getProgramList',
                    ),
                ),
            ),
            'registerProgram' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/registerProgram',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'registerProgram',
                    ),
                ),
            ),
            'verifyAccount' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/verifyAccount',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'verifyAccount',
                    ),
                ),
            ),
            'verifyUserEmail' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/verifyUserEmail',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'verifyUserEmail',
                    ),
                ),
            ),
            'getProgramDetailsByProgramID' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/getProgramDetail/:program_id',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'getProgramDetailsByProgramID',
                    ),
                ),
            ),
            'enrolledProgram' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/enrolledProgram/:program_id',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'enrolledProgram',
                    ),
                ),
            ),
            
            
            
            
            
            'adminAuth' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/adminAuth',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'adminAuth',
                    ),
                ),
            ),
            'adminPortalLogin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/adminPortalLogin',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'adminPortalLogin',
                    ),
                ),
            ),
            'admin/login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'adminPortalLogin',
                    ),
                ),
            ),
            'adminLogout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/adminLogout',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'adminLogout',
                    ),
                ),
            ),
            'adminPortal' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/adminPortal',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'adminPortal',
                    ),
                ),
            ),
            'getAdminUserInfo' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/getAdminUserInfo',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'getAdminUserInfo',
                    ),
                ),
            ),
            'getAllPrograms' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/getAllPrograms',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'getAllPrograms',
                    ),
                ),
            ),
            'getAllCourses' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/getAllCourses',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'getAllCourses',
                    ),
                ),
            ),
            'createProgram' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/createProgram',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'createProgram',
                    ),
                ),
            ),
            'updateProgram' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/updateProgram',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'updateProgram',
                    ),
                ),
            ),
            'deleteProgram' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/deleteProgram',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'deleteProgram',
                    ),
                ),
            ),
            'addProgramChapter' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/addProgramChapter',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'addProgramChapter',
                    ),
                ),
            ),
            'publishProgram' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/publishProgram',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'publishProgram',
                    ),
                ),
            ),
            'instructorDashboard' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/instructor/dashboard',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'instructorDashboard',
                    ),
                ),
            ),
            'manageCourses' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/instructor/manageCourses',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'manageCourses',
                    ),
                ),
            ),
            'instructorManageCourses' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/instructor/manageCourses/:course_id',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'instructorManageCourses',
                    ),
                ),
            ),
            'addBasicInfo' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/instructor/manageCourses/:course_id/addBasicInfo',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'addBasicInfo',
                    ),
                ),
            ),
            'instructorManageCoursePricing' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/instructor/manageCourses/:course_id/pricing',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'instructorManageCoursePricing',
                    ),
                ),
            ),
            'instructorManageCourseChapters' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/instructor/manageCourses/:course_id/chapters',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'instructorManageCourseChapters',
                    ),
                ),
            ),
            'manageCourseInstructors' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/instructor/manageCourses/:course_id/instructors',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'manageCourseInstructors',
                    ),
                ),
            ),
            'createNewCourse' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/createNewCourse',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'createNewCourse',
                    ),
                ),
            ),
            'deleteCourse' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/deleteCourse',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'deleteCourse',
                    ),
                ),
            ),
            'publishCourse' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/publishCourse',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'publishCourse',
                    ),
                ),
            ),
            'updateCourseBasicInfo' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/updateCourseBasicInfo',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'updateCourseBasicInfo',
                    ),
                ),
            ),            
            'getCourseDetailsByID' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/getCourseDetailsByID',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'getCourseDetailsByID',
                    ),
                ),
            ),            
            'updateCoursePrice' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/updateCoursePrice',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'updateCoursePrice',
                    ),
                ),
            ),        
            'addCourseInstructor' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/addCourseInstructor',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'addCourseInstructor',
                    ),
                ),
            ),       
            'createCourseChapter' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/createCourseChapter',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'createCourseChapter',
                    ),
                ),
            ),      
            'deleteChapter' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/deleteChapter',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action' => 'deleteChapter',
                    ),
                ),
            ),
//            'adminAuth' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/adminAuth',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'adminAuth',
//                    ),
//                ),
//            ),
//            'adminPortalLogin' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/adminPortalLogin',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'adminPortalLogin',
//                    ),
//                ),
//            ),
//            'admin/login' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/admin/login',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'adminPortalLogin',
//                    ),
//                ),
//            ),
//            'adminLogout' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/adminLogout',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'adminLogout',
//                    ),
//                ),
//            ),
//            'adminPortal' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/adminPortal',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'adminPortal',
//                    ),
//                ),
//            ),
//            'getAdminUserInfo' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/getAdminUserInfo',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'getAdminUserInfo',
//                    ),
//                ),
//            ),
//            'getAllPrograms' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/getAllPrograms',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'getAllPrograms',
//                    ),
//                ),
//            ),
//            'createProgram' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/createProgram',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'createProgram',
//                    ),
//                ),
//            ),
//            'updateProgram' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/updateProgram',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'updateProgram',
//                    ),
//                ),
//            ),
//            'deleteProgram' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/deleteProgram',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'deleteProgram',
//                    ),
//                ),
//            ),
//            'addProgramChapter' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/addProgramChapter',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'addProgramChapter',
//                    ),
//                ),
//            ),
//            'publishProgram' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/publishProgram',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Index',
//                        'action' => 'publishProgram',
//                    ),
//                ),
//            ),
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
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Admin' => 'Application\Controller\AdminController'
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
            'layout/admin/login' => __DIR__ . '/../view/layout/admin-login-layout.phtml',
            'layout/admin' => __DIR__ . '/../view/layout/admin-layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
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
                            'controller' => 'Application\Controller\Index',
                            'action' => 'fooBar'
                        )
                    )
                ),
                'sendMail' => array(
                    'options' => array(
                        'route' => 'sendMail <emailDetails>',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Index',
                            'action' => 'sendMail'
                        )
                    )
                ),
                'getGoogleAccessToken' => array(
                    'options' => array(
                        'route' => 'getGoogleAccessToken',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Index',
                            'action' => 'getGoogleAccessToken'
                        )
                    )
                ),
            ),
        ),
    ),
);
