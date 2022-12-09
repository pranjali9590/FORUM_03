

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login to your iDiscuss Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden= "true">&times;</span>
        </button>
      </div>
      <form action = "/forum/partials/_handlelogin.php" method="post">
      <div class="modal-body">
        <div class="mb-3">
            <label for="loginEmail" class="form-label">Username</label>
            <input type="text" class="form-control" id="loginEmail" name="loginEmail"  aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="loginPass" class="form-label">Password</label>
            <input type="password" class="form-control" id="loginPass" name="loginPass">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>