<?php 


include('./header.php');



?>


<style>

#exchange_icon{
    font-size: 50px;
    color: #757E47;
    margin-top: 4%;
}
#exchange_icon:hover{
    color: #999;
}

#submit_button{
    width: 100px;
    margin: 0 auto;
    color: #fff;
    background-color: #757E47;
    transition: .2s;
}
#submit_button:hover{
  background-color: #fff;
  color:  #757E47;
}

#submit_section{
    margin-top: 10%;
}

.page-header{
    color: #757E47;
}


/* hide arrows from input type number */
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

#page-wrapper{
    margin-bottom: 200px;
}

</style>





<div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header text-center text-info">Exchange Rate</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                    <form id="main_form"> 
                        <div class="form-group">
                            <div class="col-lg-2 col-lg-offset-1 col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1">
                                <label>Currency:</label>
                                <select id="initial_currency" class="form-control" required>
                                    <option value="">Select Currency</option>
                                    <option value="SGD">SGD</option>
                                    <option value="AUD">AUD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="JPY">JPY</option>
                                    <option value="KRW">KRW</option>
                                    <option value="CNY">CNY</option>
                                    <option value="THB">THB</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <label>Amount:</label>
                                <input id="initial_amount" type="number" step="0.01" value="0.00" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 text-center">
                                <i id="exchange_icon" class="fa fa-exchange-alt"></i>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <label>Currency:</label>
                                <select id="resultant_currency" class="form-control" required>
                                    <option value="">Select Currency</option>
                                    <option value="SGD">SGD</option>
                                    <option value="AUD">AUD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="JPY">JPY</option>
                                    <option value="KRW">KRW</option>
                                    <option value="CNY">CNY</option>
                                    <option value="THB">THB</option>
                                    <option value="USD">USD</option>
                                  </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <label>Amount:</label>
                                <input id="resultant_amount" type="text" value="0.00" class="form-control" readonly>
                            </div>
                            <div id="submit_section" class="col-lg-12 col-md-12 col-sm-12">
                                <button id="submit_button" type="submit" class="form-control theme_border"><b class="text-center">Convert</b></button>
                            </div>
                        </div>
                        
                    </form>
            </div><!--/.row-->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->



<script>





// all are fired when the page is loaded
$(document).ready(function() {
    


// keyup function for two decimal places
$('#initial_amount').keyup(function(){
if($(this).val().indexOf('.')!=-1){         
    if($(this).val().split(".")[1].length > 2){                
        if( isNaN( parseFloat( this.value ) ) ) return;
        this.value = parseFloat(this.value).toFixed(2);
    }  
}            
return this; //for chaining
});


// onsubmit event
document.getElementById("main_form").addEventListener("submit", currency_exchange);

function currency_exchange(e) {
    e.preventDefault();
    var initial_currency = document.getElementById("initial_currency").value;
    var initial_amount = document.getElementById("initial_amount").value;
    var resultant_currency = document.getElementById("resultant_currency").value;


// fetch data from API
var form = new FormData();
var settings = {
  "url": "https://api.exchangeratesapi.io/latest?base="+initial_currency,
  "method": "GET",
  "timeout": 0,
//   "headers": {
//     "Cookie": "__cfduid=d767216ffec397f4c0917783c0cba79161590922081"
//   },
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form
};

$.ajax(settings).done(function (response) {
    var data = JSON.parse(response);
    var Rate = data.rates;

var x;
for (x in Rate) {
if(x == resultant_currency){
    var multiple = Rate[x] * initial_amount;
    document.getElementById("resultant_amount").value = multiple.toFixed(2);
    break;
}
}  // end of for-in loop


}); // end of ajax function


} // end of function currency_exchange

}); // document.ready closed




</script>


<?php 

include('./footer.php'); 


?>