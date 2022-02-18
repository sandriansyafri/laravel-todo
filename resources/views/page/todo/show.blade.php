    <!-- Modal -->
    <div class="modal fade" id="showDetailTodoModal" tabindex="-1" aria-labelledby="showDetailTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row align-items-center justify-content-between w-100">
                        <div class="col-md-6">
                            <h5 class=" modal-title">Modal title</h5>
                        </div>
                        <div class="col-md-6 text-right">
                            <h5 class="modal-date"></h5>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <h1 class="display-4" id="todo">Todo</h1>
                                    <div class="d-flex">
                                        <h3><span class="badge badge-primary mr-2" id="status">New</span></h3>
                                        <h3><span class="badge badge-primary" id="priority">New</span></h3>
                                    </div>
                                </div>
                                <p class="lead mb-b">Desc:  
                                    <span id="desc"></span>
                                </p>
                             <div class="d-flex">
                                <p class=" created-human lead mb-b text-sm badge badge-primary p-3 mr-3">Created:  
                                    <span id="created_human"></span>
                                </p>
                                <p  id="status-update" style="cursor: pointer"  class="lead mb-b text-sm badge badge-warning p-3">Change Status To :  
                                    <span ></span>
                                </p>
                             </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>