app.controller('pesertaCtrl', function ($scope, Data, toaster, $uibModal) {
    var tableStateRef;
    var control_link = "m_peserta";
    $scope.formTitle = '';
    $scope.displayed = [];
    $scope.is_edit = false;
    $scope.is_view = false;
    $scope.opened = {};
    $scope.toggle = function ($event, elemId) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened[elemId] = !$scope.opened[elemId];
    };
    /** get list data */
    $scope.callServer = function callServer(tableState) {
        tableStateRef = tableState;
        $scope.isLoading = true;
        /** set offset and limit */
        var offset = tableState.pagination.start || 0;
        var limit = tableState.pagination.number || 10;
        var param = {
            offset: offset,
            limit: limit
        };
        /** set sort and order */
        if (tableState.sort.predicate) {
            param['sort'] = tableState.sort.predicate;
            param['order'] = tableState.sort.reverse;
        }
        /** set filter */
        if (tableState.search.predicateObject) {
            param['filter'] = tableState.search.predicateObject;
        }
        Data.get(control_link + '/index', param).then(function (response) {
            $scope.displayed = response.data.list;
            tableState.pagination.numberOfPages = Math.ceil(response.data.totalItems / limit);
        });
    };

    /** update */
    $scope.update = function (form) {
        $scope.is_edit = true;
        $scope.is_view = false;
        $scope.formtitle = "Edit Data : " + form.nama;
        $scope.form = form;
        $scope.form.tanggal_lahir = new Date(form.tanggal_lahir);
        $scope.form.password = '';
    };
    /** view */
    $scope.view = function (form) {
        var modalInstance = $uibModal.open({
            templateUrl: 'tpl/m_peserta/modal.html',
            controller: 'modalPesertaCtrl',
            size: 'md',
            backdrop: 'static',
            resolve: {
                form: function () {
                    return form;
                }
            }
        });
        modalInstance.result.then(function (result) {
        }, function () {

        });
    };
    /** save action */
    $scope.save = function (form) {
        var url = (form.id > 0) ? '/update' : '/create';
        Data.post(control_link + url, form).then(function (result) {
            if (result.status_code == 200) {
                $scope.is_edit = false;
                $scope.callServer(tableStateRef);
                toaster.pop('success', "Berhasil", "Data berhasil tersimpan");
            } else {
                toaster.pop('error', "Terjadi Kesalahan", setErrorMessage(result.errors));
            }
        });
    };
    /** cancel action */
    $scope.cancel = function () {
        if (!$scope.is_view) {
            $scope.callServer(tableStateRef);
        }
        $scope.is_edit = false;
        $scope.is_view = false;
    };
});

app.controller('modalPesertaCtrl', function ($state, $scope, toaster, Data, $uibModalInstance, form) {

    var control_link = "m_peserta";
    $scope.formmodal = form;
    $scope.title = "History Diklat "+ form.nama;
    $scope.is_index = true;
    $scope.is_history = false;
    $scope.close = function () {
        $uibModalInstance.dismiss('cancel');
    };

    $scope.view = function (form) {
        $scope.title = "History Detail Diklat "+ $scope.formmodal.nama;
        Data.get(control_link + '/getHistory', form).then(function (response) {
            $scope.is_index = false;
            $scope.is_history = true;
            $scope.history = response.data;
        });
    }
    
    $scope.back = function (){
        $scope.title = "History Diklat "+ $scope.formmodal.nama;
        $scope.is_index = true;
        $scope.is_history = false;
    }
});