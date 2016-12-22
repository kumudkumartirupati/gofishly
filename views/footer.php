    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2014 <a target="_blank" href="http://www.gofishly.com/" title="Online Fish Seller">Go Fishly Pvt. Ltd.</a>. All Rights Reserved.
                </div>                
            </div>
        </div>
    </footer>
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.isotope.min.js"></script>
    <script src="/js/jquery.prettyPhoto.js"></script>
    <script src="/js/jquery.bootstrap-touchspin.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/get_building.js"></script>
    <script>
        $("input[name='qtty']").TouchSpin({
            min: 1,
            max: 50,
            stepinterval: 1,
            maxboostedstep: 1,
            prefix: 'Quantity'
        });
        $(function(){
            $("#user_login").on('click', function(e){
                e.preventDefault();
                $("#user_login").hide();
                $("#user_login_loading").show();
                var uname = $('#login_uname').val();
                var pwd = $('#login_pwd').val();
                $.ajax({
                    type: "POST",
                    url: "/actions/user_action.php",
                    data: {uname: uname, pwd: pwd, ajax_login: true},
                    dataType: 'json',
                    success: function(json) {
                        if (json.status == 1) {
                            $("#form_messages").html(json.html);
                            $("#user_login").show();
                            $("#user_login_loading").hide();
                            setTimeout(function() {
                                location.reload();
                            }, 10);
                        } else {
                            $("#form_messages").html(json.html);
                            $("#user_login").show();
                            $("#user_login_loading").hide();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>