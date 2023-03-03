@extends('header')

<div class="container-fluid">
    <div>
        <form class="mx-auto pt-3" method="POST" action="{{ route('ldap.login') }}">
            <fieldset class="">
                <legend class="text-center text-6xl text-gray-700">Connexion au Portail</legend>
                <hr>
                @csrf
                <div class="text-center text-3xl pt-4">
                    <label for="inputEmail" class="control-label"><h3>Identifiant</h3></label>
                    <input type="text" name="login" placeholder="identifiant AD" id="login" value={{ old('login')}}>
                        @error("login")
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                <script>
                                    var err = @json($message);
                                    alert(err);
                                </script>
                            </div>
                        @enderror
                    <label for="inputPWD" class="pt-3 control-label"><h3>Mot de passe</h3></label>
                    <input class="" type="password" name="password" placeholder="Mot de passe">
                        @error('password')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                <script>
                                    var err = @json($message);
                                    alert(err);
                                </script>
                            </div>
                        @enderror
                    <br>
                    <input class="justify-center rounded-lg bg-blue-500 border-2 text-gray-200 transition duration-300 transform hover:scale-110 hover:border-black"
                        type="submit" placeholder="Se connecter">
                </div>
            </fieldset>
        </form>
    </div>
</div>
{{-- @endsection --}}
@extends('footer')
