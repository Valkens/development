<script type="text/javascript">
    var BASE_URL = '{{$baseUrl}}';
    var ADMIN_URL = '{{$adminUrl}}';
</script>
[[ $this->js(array('/public/js/jquery/jquery.min.js',
                    '/public/js/jquery/jquery-ui/jquery-ui.min.js',
                    '/public/js/jquery/form/validation.js',
                    '/public/js/jquery/form/validation-additional-methods.js',
                    '/public/js/jquery/tipsy/tipsy.js',
                    'js/jquery/jquery.uniform.min.js',
                    'js/jquery/jquery.chosen.min.js',
                    'js/jquery/tagsinput/tagsinput.min.js',
                    'js/jquery/confirm/confirm.js',
                    'js/utility.js',
                    'js/main.js'))
]]