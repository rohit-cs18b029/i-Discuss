<!-- Modal -->
<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signUpModalLabel">SignUp Now</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="partials/handleSignUp.php" method="POST">
                    <div class="form-group">
                        <label for="email">Username</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm password</label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                        <small class="form-text text-muted">Re-type the same password</small>
                    </div>
                    <button type="submit" class="btn btn-primary">SignUp</button>
                </form>
            </div>
        </div>
    </div>
</div>