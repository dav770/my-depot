

  <script src="https://js.stripe.com/v2/"></script>

<!-- import de jquery -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<!-- Processus stripe -->
<?php
require ('stripe.php');

$stripe = new Stripe('sk_test_51LonIAJGdQZLpN4gvon9D3oWuEha8DanKggp85TZXdVjOjqvDzLHdkUK8KvmkrjjiD4jGd49o0SKQ8COEB3NHSeK00tT8hE0Eg'
);
// echo(print_r($stripe));
// die;
// $stripe->customers->create([
//   'description' => 'dav from API',
//   'address'=>[
//     'city'=>'paris',
//   ],
//   'email'=>'dav@test.fr',
//   'name'=>'dav'
// ]);
?>