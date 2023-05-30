@section('intercom')
    @if(isset($user))
        <script>
            window.intercomSettings = {
                user_hash: "<?php echo
                hash_hmac("sha256", $user->email, "8cHwpG5bpqnj8PA5aytlNhzc_gFjBUcFN3WmLvu4");
                        ?>",
                email : "<?= e($user->email); ?>",
                name : "<?= ($user->name); ?>",
                user_id : "<?= ($user->id); ?>",
                first_name : "<?= ($user->first_name); ?>",
                last_name : "<?= ($user->last_name); ?>",
                app_id: "qmxaln7x",
                current_page : "<?= Request::getUri(); ?>",
                active : "<?= e($user->active); ?>",
                last_order : "<?= e($user->last_order); ?>",
                avg_cart : "<?= e($user->avg_cart); ?>",
                phone : "<?= e($user->phone); ?>",
                billing_status : "<?= e($user->billing_status); ?>",
                billing_method : "<?= e($user->billing_method); ?>",
                postalcode : "<?= e($user->postalcode); ?>",
                total : "<?= e($user->total); ?>",
                referrer : "<?= isset($_SERVER['HTTP_REFERER']) ? e($_SERVER['HTTP_REFERER']) : ''; ?>",
                created_at : "<?= $user->created_at->getTimestamp(); ?>",

            };
        </script>
        <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/qmxaln7x';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
	@else
        <script>
            window.intercomSettings = {
                app_id: 'qmxaln7x'
            };
            (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/qmxaln7x';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
        </script>
    @endif
@show
