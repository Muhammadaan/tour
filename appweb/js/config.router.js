angular.module('app').run(
        ['$rootScope', '$state', '$stateParams', 'Data', '$transitions',
            function ($rootScope, $state, $stateParams, Data, $transitions) {
                $rootScope.$state = $state;
                $rootScope.$stateParams = $stateParams;
                /** Pengecekan login */
                $transitions.onStart({}, function ($transition$) {
                    var toState = $transition$.$to();
                    Data.get('site_web/session').then(function (results) {
                        if (results.status_code == 200) {
                            $rootScope.user = results.data.user;
                            /** Check hak akses */
                            var globalmenu = ['site.dashboard', 'master.userprofile', 'verivikasi.daftarulang', 'access.signin'];
                            if (globalmenu.indexOf(toState.name) >= 0) {
                            } else {
                                if (results.data.user.akses[(toState.name).replace(".", "_")]) {
                                } else {
                                    $state.go("access.forbidden");
                                }
                            }
                            /** End */
                        } else {
                            $state.go("access.signin");
                        }
                    });
                });
            }
        ]);
angular.module('app').config(
        ['$stateProvider', '$urlRouterProvider',
            function ($stateProvider, $urlRouterProvider) {
                $urlRouterProvider.otherwise('/site/dashboard');
                $stateProvider.state('site', {
                    abstract: true,
                    url: '/site',
                    templateUrl: 'tpl/app.html'
                }).state('site.dashboard', {
                    url: '/dashboard',
                    templateUrl: 'tpl/dashboard.html',
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function ($ocLazyLoad) {
                                return $ocLazyLoad.load(['chart.js']).then(function () {
                                    return $ocLazyLoad.load('tpl/site/dashboard.js');
                                });
                            }
                        ]
                    }
                })
                        /** Set default page */
                        .state('access', {
                            url: '/access',
                            template: '<div ui-view class="fade-in-right-big smooth"></div>'
                        }).state('access.signin', {
                    url: '/signin',
                    templateUrl: 'tpl/page_signin.html',
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function ($ocLazyLoad) {
                                return $ocLazyLoad.load('tpl/site/site.js').then();
                            }
                        ]
                    }
                }).state('access.404', {
                    url: '/404',
                    templateUrl: 'tpl/page_404.html'
                }).state('access.forbidden', {
                    url: '/forbidden',
                    templateUrl: 'tpl/page_forbidden.html'
                })
                        /** End */
                        /** Router request master */
                        .state('master', {
                            url: '/master',
                            templateUrl: 'tpl/app.html'
                        }).state('master.userprofile', {
                    url: '/profile',
                    templateUrl: 'tpl/m_user/profil.html',
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function ($ocLazyLoad) {
                                return $ocLazyLoad.load('tpl/m_user/profil.js');
                            }
                        ]
                    }
                })
                        .state('master.user', {
                            url: '/user',
                            templateUrl: 'tpl/m_user/user.html',
                            resolve: {
                                deps: ['$ocLazyLoad',
                                    function ($ocLazyLoad) {
                                        return $ocLazyLoad.load('tpl/m_user/user.js');
                                    }
                                ]
                            }
                        })
                        .state('master.roles', {
                            url: '/roles',
                            templateUrl: 'tpl/m_roles/index.html',
                            resolve: {
                                deps: ['$ocLazyLoad',
                                    function ($ocLazyLoad) {
                                        return $ocLazyLoad.load('tpl/m_roles/roles.js');
                                    }
                                ]
                            }
                        })
                        .state('master.artikel', {
                            url: '/artikel',
                            templateUrl: 'tpl/artikel/artikel.html',
                            resolve: {
                                deps: ['$ocLazyLoad',
                                    function ($ocLazyLoad) {
                                        return $ocLazyLoad.load('tpl/artikel/artikel.js');
                                    }
                                ]
                            }
                        })
                        .state('master.kategori_artikel', {
                            url: '/kategori_artikel',
                            templateUrl: 'tpl/kategori_artikel/kategori_artikel.html',
                            resolve: {
                                deps: ['$ocLazyLoad',
                                    function ($ocLazyLoad) {
                                        return $ocLazyLoad.load('tpl/kategori_artikel/kategori_artikel.js');
                                    }
                                ]
                            }
                        })
                        .state('master.slider', {
                            url: '/slider',
                            templateUrl: 'tpl/slider/slider.html',
                            resolve: {
                                deps: ['$ocLazyLoad',
                                    function ($ocLazyLoad) {
                                        return $ocLazyLoad.load(['naif.base64']).then(function () {
                                            return $ocLazyLoad.load('tpl/slider/slider.js');
                                        });
                                    }
                                ]
                            }
                        })
                        .state('master.kategori_pengaduan', {
                            url: '/kategori_pengaduan',
                            templateUrl: 'tpl/kategori_pengaduan/kategori_pengaduan.html',
                            resolve: {
                                deps: ['$ocLazyLoad',
                                    function ($ocLazyLoad) {
                                        return $ocLazyLoad.load('tpl/kategori_pengaduan/kategori_pengaduan.js');
                                    }
                                ]
                            }
                        })
                        .state('master.setting', {
                            url: '/setting',
                            templateUrl: 'tpl/setting/setting.html',
                            resolve: {
                                deps: ['$ocLazyLoad',
                                    function ($ocLazyLoad) {
                                        return $ocLazyLoad.load('tpl/setting/setting.js');
                                    }
                                ]
                            }
                        })
                      

                        .state('master.text_slider', {
                            url: '/text-slider',
                            templateUrl: 'tpl/m_text_slider/index.html',
                            resolve: {
                                deps: ['$ocLazyLoad',
                                    function ($ocLazyLoad) {
                                        return $ocLazyLoad.load('tpl/m_text_slider/index.js');
                                    }
                                ]
                            }
                        })


                /*VERIVIKASI */


            }
        ]);
