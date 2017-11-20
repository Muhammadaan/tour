app.controller('profilCtrl', function($scope, Data, toaster, $rootScope) {
    Data.get('appweb_user/view').then(function(result) {
        $scope.form = result.data;
    });
    $scope.save = function(form) {
        Data.post('appweb_user/updateprofil', form).then(function(result) {
            if (result.status_code == 200) {
                $scope.is_edit = false;
                toaster.pop('success', "Berhasil", "Data berhasil tersimpan");
            } else {
                toaster.pop('error', "Terjadi Kesalahan", setErrorMessage(result.errors));
            }
        });
    };
})