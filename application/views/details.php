<script>

    $('.profilebtn').click(function () {
        var uid = $(this).attr('id');
        $.ajax({
            url: '<?php echo base_url("search/get_details");?>',
            type: "POST",
            dataType: 'html',
            data: {id: uid},
            success: function (data) {
                $('#results').toggle();
                $('#details').html(data).show();
                $("#details").get(0).scrollIntoView();
                $("#details").attr("aria-live", "polite");
                
            },

        });
    });




</script>