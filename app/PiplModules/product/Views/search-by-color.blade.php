<div id="cp8" data-format="alias" class="input-group colorpicker-component">
    <input type="text" value="primary" class="form-control" />
    <span class="input-group-addon"><i></i></span>
</div>
<script>
    $(function() {
        $('#cp8').colorpicker({
            colorSelectors: {
                'black': '#000000',
                'white': '#ffffff',
                'red': '#FF0000',
                'default': '#777777',
                'primary': '#337ab7',
                'success': '#5cb85c',
                'info': '#5bc0de',
                'warning': '#f0ad4e',
                'danger': '#d9534f'
            }
        });
    });
</script>