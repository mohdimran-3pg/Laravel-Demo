<div>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">IT Topics</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/">Home</a></li>
      <li><a href="/about">About</a></li>
      
      @guest
        <li><a class="w3-bar-item w3-button w3-hide-small" href="{{ route('login') }}">{{ __('Login') }}</a></li>
        @if (Route::has('register'))
                <li><a class="w3-bar-item w3-button w3-hide-small" href="{{ route('register') }}">{{ __('Register') }}</a></li>
        @endif
    @else
            <li><a id="navbarDropdown" class="w3-bar-item w3-button w3-hide-small dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            
          </li>
          <li>

            <a id="navbarDropdown" onclick="document.getElementById('logout-form').submit()" class="w3-bar-item w3-button w3-hide-small dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ __('Logout') }} <span class="caret"></span>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </a>
    
          </li>
    @endguest

    </ul>
  </div>
</nav>
</div>

<script>
  /* When the user clicks on the button, 
  toggle between hiding and showing the dropdown content */
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }
  
  // Close the dropdown if the user clicks outside of it
  window.onclick = function(e) {
    if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("myDropdown");
      if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
      }
    }
  }
  </script>