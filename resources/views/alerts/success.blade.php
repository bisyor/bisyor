@if (session('create-subscribers'))
    <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
      <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
      <strong> {{ session('create-subscribers') }} </strong>
    </div>
@endif

@if (session('success-changed'))
    <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
      <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
      <strong> {{ session('success-changed') }} </strong>
    </div>
@endif

@if (session('success-saved'))
    <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
      <!-- <a href="#" class="closes" data-dismiss="alert" aria-label="close">&times;</a> -->
      <strong> {{ session('success-saved') }} </strong>
    </div>
@endif

@if (session('success-submit-message'))
    <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
      <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
      <center><strong> {{ session('success-submit-message') }} </strong></center>
    </div>
@endif

@if (session('success-deleted-message'))
    <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
      <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
      <center><strong> {{ session('success-deleted-message') }} </strong></center>
    </div>
@endif
@if (session('error-message'))
    <div class="alert alert-danger alert-dismissable custom-success-box" style="margin: 15px;">
      <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
      <center><strong> {{ session('error-message') }} </strong></center>
    </div>
@endif
