<style type="text/css">
.k-window  div.k-window-content {overflow: hidden; }
.ps_err {color: red;}
</style>
<script>
    var grid_instance;
    var dialog;
    var id_dialog = '#dialog';
    var id_grid = '#grid';

    function grid_refresh() {
        $(id_grid).data("kendoGrid").dataSource.read();
        $(id_grid).data('kendoGrid').refresh();
    }

    $(function() {
        grid_limit = <?php echo isset($limit) ? intval($limit) : 0; ?>;
        dialog = $(id_dialog).kendoWindow({
            actions: ["Pin", "Close"],
            draggable: false,
            modal: true,
            pinned: false,
            resizable: false,
            width: "650px",
            /*height: "450px",*/
            title: "User detail",
        }).data("kendoWindow");

        $('body').on('click', '.btn_close_dialog', function(e){
            e.preventDefault();
            dialog.close();
        });

        $('body').on('click', '.btn_delete', function(e){
            e.preventDefault();
            i = $(this);
            var kendoWindow = $("<div />").kendoWindow({
                title: "Confirm",
                resizable: false,
                width: 450,
                modal: true
            });

            kendoWindow.data("kendoWindow")
                .content($("#delete-confirmation").html())
                .center().open();

            kendoWindow
                .find(".delete-confirm, .delete-cancel")
                .click(function() {
                    if ($(this).hasClass("delete-confirm")) {
                        $.ajax({
                            type: 'POST',
                            url: i.attr('href'),
                            dataType: 'json',
                            success: function(data){
                                if (data.status == true) {
                                    var grid = $(id_grid).data("kendoGrid");
                                    var row = grid.select();
                                    var uid = row.data("uid");
                                    row.remove();
                                    grid_refresh();
                                }
                            },
                            error: function(err){}
                        });
                    }

                    kendoWindow.data("kendoWindow").close();
                })
                .end()
        });

        $('body').on('click', '.btn_edit', function(e){
            e.preventDefault();
            i = $(this);
            $.ajax({
                type: 'GET',
                url: i.attr('href'),
                success: function(data){
                    dialog.content(data);
                    dialog.center();
                    dialog.open();
                },
                error: function(err){
                    alert('error');
                }
            });
        });

        grid_instance = $(id_grid).kendoGrid({
            dataSource: {
                transport: {
                    read: "<?php echo current_url(); ?>",
                    "contentType":"application\/json",
                    "type":"POST"
                },
                schema: {
                    data: "data",
                    total: "total"
                },
                pageSize: grid_limit,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true
            },
            columns: [
                { field: "id", title: '#', width: 50, },
                { field: "username", title: 'Username', width: 200, },
                { field: "email", title: 'Email' },
                { field: "option", title: 'Option', filterable: false, width: 150, template: function(data) {
                        html = "<a id='btn_edit_"+data.id+"' href='<?php echo create_url('sys/user/edit'); ?>/"+data.id+"' class='btn_edit btn btn-info btn-xs'><span class='glyphicon glyphicon-pencil'></span>&nbsp;Edit</a>&nbsp;";
                        html = html + "<a _id='"+data.id+"' href='<?php echo create_url('sys/user/delete'); ?>/"+data.id+"' class='btn_delete btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span>&nbsp;Delete</a>";
                        return html;
                    }
                }
            ],
            selectable: "row",
            filterable: true,
            groupable: true,
            scrollable: true,
            reorderable: true,
            columnMenu: true,
            sortable: {
                mode: "multiple",
                allowUnsort: true
            },
            sortable: false,
            navigatable: true,
            pageable: {
                pageSize : grid_limit,
            }
        });

        function showDetails(e) {
            e.preventDefault();
            alert("Hello");
        }
    });
</script>
<div id="grid"></div>

<div id="dialog" style="display: none;"></div>
<script id="delete-confirmation" type="text/x-kendo-template">
    <div class="row">
        <span class="col-md-2"></span>
        <span class="col-md-8">
            <p class="delete-message">Are you sure want to delete this user?</p>
        </span>
        <span class="col-md-2"></span>
    </div>
    <div class="row">
        <span class="col-md-7"></span>
        <span class="col-md-5">
            <span class="pull-right">
                <button class="delete-confirm btn btn-danger">Yes</button>
                <a href="#" class="delete-cancel btn btn-default">No</a>
            </span>
        </span>
    </div>
</script>