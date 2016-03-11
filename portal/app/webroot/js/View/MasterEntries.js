$(function() {

    $('#txtBusca').keyup(function() {
        var that = this;
        $.each($('tr'),
                function(i, val) {
                    if ($(val).text().indexOf($(that).val()) == -1) {
                        $('tr').eq(i).hide();
                    } else {
                        $('tr').eq(i).show();
                    }
                });
    });

    $('#example').each(function() {
        var currentPage = 0;
        var numPerPage = 7;
        var $table = $(this);
        $table.bind('repaginate', function() {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function(event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertAfter($table).find('span.page-number:first').addClass('active');

    });

    $('#txtBuscaFornecedores').keyup(function() {
        var that = this;
        $.each($('tr'),
                function(i, val) {
                    if ($(val).text().indexOf($(that).val()) == -1) {
                        $('tr').eq(i).hide();
                    } else {
                        $('tr').eq(i).show();
                    }
                });
    });

    $('#tab-fornecedores').each(function() {
        var currentPage = 0;
        var numPerPage = 7;
        var $table = $(this);
        $table.bind('repaginate', function() {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function(event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertAfter($table).find('span.page-number:first').addClass('active');

    });

});


function clickEditProvider(index) {

    $.ajax({
        type: "POST",
        data: {
            providerIndex: index
        },
        url: "/jezzy-master/portal/masterEntries/editProvider",
        success: function(result) {

            $("#cadastro-recebe").html(result);
            $('#myModal').modal('toggle');
            $('#myModal').modal('show');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });

}

function removeProvider(id) {

    $.ajax({
        type: "POST",
        data: {
            id: id
        },
        url: "/jezzy-master/portal/masterEntries/removeProvider",
        success: function(result) {
            // $($("#" + id)).closest('tr').remove();
            $("#status-" + id).html("<span class='label label-danger'>Inativo</span>");
            $("#button-" + id).html('<span class="glyphicon glyphicon-play table-icon reative" onclick="reativeProvider(' + id + ');"></span>');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });
}

function reativeProvider(id) {

    $.ajax({
        type: "POST",
        data: {
            id: id
        },
        url: "/jezzy-master/portal/masterEntries/reativeProvider",
        success: function(result) {
            // $($("#" + id)).closest('tr').remove();
            $("#status-" + id).html("<span class='label label-success'>Ativo</span>");
            $("#button-" + id).html(' <span class="glyphicon glyphicon-remove table-icon remove" onclick="removeProvider(' + id + ');"></span>');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });

}

/**
 * C O M P A N Y
 */
function showNewCompany() {

    $.ajax({
        type: "POST",
        data: {
        },
        url: "/jezzy-master/portal/masterEntries/showSaveCompany",
        success: function(result) {
            $("#modal-recebe").html(result);
            $('#myModal').modal('toggle');
            $('#myModal').modal('show');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });
}

function clickEditCompany(index) {


    $.ajax({
        type: "POST",
        data: {
            companyIndex: index
        },
        url: "/jezzy-master/portal/masterEntries/editCompany",
        success: function(result) {

            $("#providerCompanyForm").attr('action', 'masterEntries/saveCompany');

            $("#cadastro-recebe").html(result);
            $('#myModal').modal('toggle');
            $('#myModal').modal('show');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });
}

function removeCompany(id) {

    $.ajax({
        type: "POST",
        data: {
            id: id
        },
        url: "/jezzy-master/portal/masterEntries/removeCompany",
        success: function(result) {
            // $($("#" + id)).closest('tr').remove();
            $("#status-" + id).html("<span class='label label-danger'>Inativo</span>");
            $("#button-" + id).html('<span class="glyphicon glyphicon-play table-icon reative" onclick="reativeCompany(' + id + ');"></span>');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });
}

function reativeCompany(id) {

    $.ajax({
        type: "POST",
        data: {
            id: id
        },
        url: "/jezzy-master/portal/masterEntries/reativeCompany",
        success: function(result) {
            // $($("#" + id)).closest('tr').remove();
            $("#status-" + id).html("<span class='label label-success'>Ativo</span>");
            $("#button-" + id).html(' <span class="glyphicon glyphicon-remove table-icon remove" onclick="removeCompany(' + id + ');"></span>');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });


}


