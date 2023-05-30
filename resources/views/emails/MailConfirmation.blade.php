<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="background: #e5e5e5; padding: 30px;" >

<div style="max-width: 320px; margin: 0 auto; padding: 20px; background: #fff;">
	<h3>Erreurs détectées : {{$nb0}} factures n'ont pas été enregistrées sur Odoo, {{$nbMod}} n'ont pas été correctement modifées. </h3> <br>
	@if ($nb0 > 0)
		<p>Factures dont le transfert a échoué (il est possible que le problème ait été causé uniquement par la première facture) :   </p>
		<ul>
			@foreach ($d0 as $i)
				<li> {{$i}} </li>
			@endforeach
		</ul>
	@endif
	<br>
	@if ($nbMod > 0)
		<p>Factures dont la modification a échoué (il est possible que le problème ait été causé uniquement par la première facture) :</p>
		<ul>
			@foreach ($dMod as $i)
				<li> {{$i}} </li>
			@endforeach
		</ul>
	@endif
</div>

</body>
</html>