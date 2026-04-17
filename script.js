$(document).ready(function(){

$('#addCourse').click(function(){

var row = $('.course-row').first().clone();
row.find('input').val('');
$('#courses').append(row);

});

$('#gpaForm').submit(function(e){

e.preventDefault();

$.ajax({

url:"calculate.php",
type:"POST",
data:$(this).serialize(),
dataType:"json",

success:function(response){

if(response.success){

var gpa = parseFloat(response.gpa);

$('#result').removeClass("pass fail");

if(gpa >= 2){
$('#result').addClass("pass");
$('#result').html("✅ Passed - GPA = " + gpa.toFixed(2));
}else{
$('#result').addClass("fail");
$('#result').html("❌ Failed - GPA = " + gpa.toFixed(2));
}

$('#result').append(response.tableHtml);

var percent = (gpa/4)*100;

$('#gpaBar').css('width',percent+"%");

$('#gpaBar').removeClass(
'bg-success bg-info bg-warning bg-danger'
);

if(gpa >=3.7){
$('#gpaBar').addClass('bg-success');
}
else if(gpa >=3){
$('#gpaBar').addClass('bg-info');
}
else if(gpa >=2){
$('#gpaBar').addClass('bg-warning');
}
else{
$('#gpaBar').addClass('bg-danger');
}

}

}

});

});

$('#exportCSV').click(function(){
window.location="export.php";
});

});
