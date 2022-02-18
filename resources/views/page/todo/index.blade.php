@extends('layouts.admin.main')

@section('title')
Todos
@endsection

@include('vendor.datatables')
@include('vendor.sweet-alert')
@include('vendor.toasttr')
@section('content')
<div class="row">
    <div class="col">
        <div class="input-group mb-3">
            <button class="btn  btn-primary mr-3" type="button" onclick="addTodo(`{{ route('todo.store') }}`)">
                <i class="fa fa-plus text-xs mr-2"></i> Add Todo
            </button>
            <button class="btn  btn-danger mr-3" type="button" onclick="delete_multiple(`{{ route('todo.delete-multiple') }}`)">
                <i class="fa fa-trash text-xs mr-2"></i> Delete All
            </button>
            <button class="btn  btn-warning " type="button" onclick="update_multiple(`{{ route('todo.update-multiple') }}`)">
                <i class="fa fa-pen text-xs mr-2"></i> Finished All
            </button>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Todo Lists</h3>
                <div class="card-tools">
                     <label for="">Status </label>
                    <select id="filter_status"  data-column="4"  id="" class="form-control">
                        <option value="">SELECT STATUS</option>
                        <option value="Finished">Finished</option>
                        <option value="Not yet">Not Yet</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm" id="table">
                    <thead class="text-uppercase">
                        <tr class="text-center">
                            <th style="width: 10px">#</th>
                            <th style="width: 10px">
                                <input type="checkbox" id="trigger_multiple_checkbox">
                            </th>
                            <th style="width: 20%">Date</th>
                            <th style="width: 60%">Todos</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('page.todo.form')
@include('page.todo.show')
@endsection

@push('js')
<script>
    let modal = '#todoModal'
    let modal_detail = '#showDetailTodoModal';
    let table;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    $(document).ready(function () {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ route('todo.data') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    class: 'text-center',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'delete-multiple',
                    class: 'text-center',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'created_at',
                    class: 'text-center',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'todo',
                    class: 'text-center'
                },
                {
                    data: 'status',
                    class: 'text-center',
                },
                {
                    data: 'priority',
                    class: 'text-center'
                },
                {
                    data: 'action',
                    class: 'text-center',
                    searchable: false,
                    sortable: false
                },
             
            ]
        });
    })

    $('#filter_status').change(function(){
        table.column($(this).data('column'))
            .search($(this).val())
            .draw()
    })

    function resetForm() {
        $(`${modal} form`).trigger("reset");
    }

    function submitForm(e, form) {
        e.preventDefault()
        $.ajax({
                type: 'post',
                url: $(form).attr('action'),
                data: $(form).serialize()
            })
            .done(({
                ok,
                status,
                message,
                data
            }) => {
                if (ok && status === 200) {
                    toastr.success(message)
                    table.ajax.reload();
                    resetForm();
                    $(`${modal}`).modal('hide')
                }
            })
            .fail(({
                responseJSON: {
                    errors,
                    message
                }
            }) => {
                alert(message)
            })
    }

    function addTodo(url) {
        resetForm();
        $(`${modal} form [name=_method]`).val("POST")
        $(`${modal} form`).attr('action', url)
        $(`${modal} form .btn-submit`).text('Add')
        $(`${modal} form .modal-title`).text('Add Todo')
        $(`${modal}`).modal('show')
    }

    function loadFields(fields) {
        for (let field in fields) {
            if (field === 'priority') {
                $(`[name=${field}]`).prop('checked', fields[field])
            }
            $(`[name=${field}]`).val(fields[field])

        }
    }

    function getTodo(url) {
        let todo = $.get(url)
            .done((res) => res)
            .fail(e => e)

        return todo;
    }

    async function detailTodo(url) {
        let {
            ok,
            status,
            data
        } = await getTodo(url)
        $(`${modal_detail} #priority`).removeClass('badge-danger')
        $(`${modal_detail} #priority`).removeClass('badge-success')
        $(`${modal_detail} #status`).removeClass('badge-secondary')
        $(`${modal_detail} #status`).removeClass('badge-success')

        if (ok && status === 200) {
            $(`${modal_detail} .modal-date`).text(data.created)
            $(`${modal_detail} #todo`).text(data.todo)
            $(`${modal_detail} #desc`).text(data.desc)
            $(`${modal_detail} #created_human`).text(data.created_human)
            $(`${modal_detail} #status-update span`).text(!data.status ? 'Finished' : 'Not yet')

            $(`${modal_detail} #status-update`).click(function (e) {
                $.post({
                        type: 'PUT',
                        url: data.url,
                        data: {
                            status: !data.status
                        }
                    })
                    .done((res) => {
                        if (res.ok && res.status === 200) {
                            table.ajax.reload();
                            $(`${modal_detail}`).modal('hide')
                            $(`${modal_detail} #status-update span`).text(!res.data.status ? 'Finished' : 'Not yet')
                        }
                    })
            })


            $(`${modal_detail} #priority`).text(data.priority ? 'Important' : 'Normal').addClass(data.priority ? 'badge-danger' : 'badge-success')
            $(`${modal_detail} #status`).text(data.status ? 'Finished' : 'Not yet').addClass(data.status ? 'badge-success' : 'badge-secondary')
            $(`${modal_detail}`).modal();
            $(`${modal_detail} .modal-title`).text('Detail')

        }
    }

    function editTodo(url) {
        $.get(url)
            .done(({
                ok,
                status,
                data
            }) => {
                if (ok & status === 200) {
                    loadFields(data)
                    $(`${modal} form [name=_method]`).val("PUT")
                    $(`${modal} form`).attr('action', url)
                    $(`${modal} form .btn-submit`).text('Update')
                    $(`${modal} form .modal-title`).text('Edit Todo')
                    $(`${modal}`).modal('show')
                }
            })
            .fail((e) => console.log(e))

    }

    function deleteTodo(url) {

        Swal.fire({
            title: 'Delete Item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                        url,
                        type: 'DELETE',
                    })
                    .done(({
                        ok,
                        status,
                        message
                    }) => {
                        if (ok && status === 200) {
                            table.ajax.reload()
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    })
                    .fail((e) => console.log(e))
            }
        })
    }

    $('#trigger_multiple_checkbox').change(function () {
        $('.item_multiple').prop('checked', $(this).is(':checked'))
    })

    function delete_multiple(url) {
        if (!($('.item_multiple:checked').length > 0)) {
            toastr.warning('No item selected!')
            $('#trigger_multiple_checkbox').prop('checked', false);
            return;
        }

        let val = [];
        $('.item_multiple:checked').each(function (i) {
            val[i] = $(this).val()
        })


        Swal.fire({
            title: 'Delete Item Selected?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                        url,
                        type: "DELETE",
                        data: {
                            id: val
                        }
                    })
                    .done(({
                        ok,
                        status,
                        message
                    }) => {
                        if (ok && status === 200) {
                            $('#trigger_multiple_checkbox').prop('checked', false);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            table.ajax.reload();

                        }
                    })
                    .fail((e) => console.log(e))
            }
        })

    }

    function update_multiple(url) {
        if (!($('.item_multiple:checked').length > 0)) {
            toastr.warning('No item selected!')
            $('#trigger_multiple_checkbox').prop('checked', false);
            return;
        }

        let val = [];
        $('.item_multiple:checked').each(function (i) {
            val[i] = $(this).val()
        })

        Swal.fire({
            title: 'Update All Item Selected?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, updated it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                        url,
                        type: "PUT",
                        data: {
                            id: val
                        }
                    })
                    .done(({
                        ok,
                        status,
                        message
                    }) => {
                        if (ok && status === 200) {
                            $('#trigger_multiple_checkbox').prop('checked', false);
                            Swal.fire(
                                'Updated!',
                                'Your file has been updated.',
                                'success'
                            )
                            table.ajax.reload();

                        }
                    })
                    .fail((e) => console.log(e))
            }
        })

    }
</script>
@endpush