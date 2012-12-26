$.each({
    
    calculate_bill_amount: function(form_name,no_of_rows){

        var i;
        var row_total;
        var grand_total;
        grand_total=0;


        for(i=1; i<= no_of_rows;i++){
            if($(form_name+'_item'+i).val() != '')
                row_total = $(form_name+'_qty'+i).val() * $(form_name+'_rate'+i).val();
            else
                row_total=0;
            if(isNaN(row_total)){
                row_total=0;
            }
            $(form_name+'_amount'+i).val(row_total);
            grand_total += row_total;
        }

        $(form_name+'_total_amount').val(grand_total);
    },

    validate_bill_figuers: function(form_name, no_of_rows){
        alert('hi');
    }
},$.univ._import);