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
        $(document).ready(function () {
            $("a#confirmDelete").click(function(e) {
                if (!confirm("You are about to delete an Item. This action is not reversible. Are you sure?")) {
                    e.preventDefault();
                    return;
                }
            });
            $radio_value = $('input:radio[name=hasPrm]:checked').val();
            change_radio_options($radio_value);
            $radios = $('input:radio[name=hasPrm]');
            $radios.change(function() {
                $radio_value = $('input:radio[name=hasPrm]:checked').val();
                change_radio_options($radio_value);
            });
        });
        function change_radio_options($radio_value) {
            if ($radio_value == 0) {
                $('#pchopping-styles').hide();
                $('#pcleaning-styles').hide();
                $('#pdefaultpacking-option').hide();
                $('#pbaseprice-option').hide();
                $('#rchopping-styles').show();
                $('#rcleaning-styles').show();
                $('#rdefaultpacking-option').show();
                $('#rbaseprice-option').show();
                $('#fish-options').show();
            }
            if ($radio_value == 1) {
                $('#rchopping-styles').hide();
                $('#rcleaning-styles').hide();
                $('#rdefaultpacking-option').hide();
                $('#rbaseprice-option').hide();
                $('#pchopping-styles').show();
                $('#pcleaning-styles').show();
                $('#pdefaultpacking-option').show();
                $('#pbaseprice-option').show();
                $('#fish-options').show();
            }
            if ($radio_value == 2) {
                $('#rchopping-styles').show();
                $('#rcleaning-styles').show();
                $('#rdefaultpacking-option').show();
                $('#rbaseprice-option').show();
                $('#pchopping-styles').show();
                $('#pcleaning-styles').show();
                $('#pdefaultpacking-option').show();
                $('#pbaseprice-option').show();
                $('#fish-options').show();
            }
        }
    </script>
</body>
</html>