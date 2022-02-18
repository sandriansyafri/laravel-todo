<div class="row">
    <div class="col">
        <!-- Modal -->
        <div class="modal fade"  id="todoModal" tabindex="-1" aria-labelledby="todoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="todoModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="todo">Todo</label>
                                            <input id="todo" type="text" class="form-control" name="todo">
                                        </div>
                                        <div class="mb-3">
                                            <label for="desc">Description</label>
                                            <textarea id="desc" name="desc" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="priority" name="priority">
                                                <label for="priority" class="custom-control-label">Important</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="submitForm(event,this.form)" type="submit" class="btn btn-primary btn-submit px-5 py-2"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>