@section('BaseJsFunction')

    {{--    Unify Functions--}}
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
            // clear cache
            // caches.keys().then(function (cacheNames) {
            //     cacheNames.forEach(function (cacheName) {
            //         caches.delete(cacheName);
            //     });
            // });
        } else {
            console.error("Service workers are not supported.");
        }
        $(window).on('load', function () {
            if (!checkCookies()) {
                $('body').empty();
                $('body').append('<div class="w-100 text-center"><img id="cookieDisabled" src="{{ asset("img/Other/cookieDisabled.jpg?4") }}" alt="دستیار اینستاگرام" class="g-pt-7 g-pt-0--lg"></div>');
                console.log('cookie is disabled!');
            }
        });

        // check cookie
        function checkCookies() {
            if (navigator.cookieEnabled) return true;

            // set and read cookie
            document.cookie = "cookietest=1";
            let ret = document.cookie.indexOf("cookietest=") != -1;

            // delete cookie
            document.cookie = "cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT";

            return ret;
        }

        $(document).ready(function () {
            setTimeout(function () {
                autosize(document.getElementById("bioText"));
            }, 10);
        })
    </script>
    </html>
@endsection

