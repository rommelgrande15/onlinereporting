{{-- <html>

    

<head>
    <title>

    </title>
  <link href="/js/loadingReport/pace-master/themes/blue/pace-theme-center-atom.css" rel="stylesheet" />
</head>
<body >
   
</body>
</html>

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>

<script src="/js/loadingReport/pace-master/pace.min.js">

</script>

<script>
$( document ).ready(function() {


    $.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

var href = location.href;

var id=href.match(/([^\/]*)\/*$/)[1];
$.ajax({
   type:'GET',
   url:'/loadingreport/'+id+'',
   success:function(data){
    
console.log(data);
   }

});


});
    </script>
	
 --}}