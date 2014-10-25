<?php
Yii::app()->clientScript->registerScript('show_transactions', ' 
        $(document).on("click", "#dim_transactions td a", function(e) {
            e.preventDefault();
            var ajax_url = $(e.target).attr("href");
            $("#dim_transactions").append(\'<div class="message-loading"><i class="icon-spin icon-spinner orange2 bigger-160"></i></div>\');
            $.ajax({
                type: "POST",
                url: ajax_url,
                error: function(){
                    alert("error");
                },
                beforeSend: function(){
                    // Here Loader animation
                    //$("#news").html("");
                },
                success: function(data) {
                    $("#dim_transactions").find(".message-loading").remove();
                    $("#transaktion_data").html(data);

                }
            });

        });
         ');   