@if (session("mensaje"))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Mensaje sistema insuval</h5>
    <ul>
        <li>{{ session("mensaje") }}</li>
    </ul>
 </div>
 @endif