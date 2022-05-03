<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## creation events
on commence par créer la table dans la database `php artisan make:model events` puis on ajoute un drapeau pour lier le model a une database ` -m` et un drapeau f pour creer une factory est utiliser faker (library de fake user,url,etc..)
et un drapeau r pour le relier a un controller

## creation des relations de tables et des tables
quand on debute un projet, il faut d'abord créer les relations entre les tables pour que tout soit bien défini!
`$table->string('content')` et des relations hasmany $table->foreignIdFor(User::class);

quand on créé les relations, ne pas oublier d'importer les class (ctrl+alt+) et on selectionne la class `user App\class\user;

les relations entre les models et les tables ont ete stipule. maintenant on peut utiliser faker via factory pour simuler des données

        $title = $this->faker->sentence(rand(2, 6));`

        dans la variable title nous faisons appel a la library faker et notamment a la section sentence avec des options rand (random) pour signifer des mots compris entre 2 et 6 dans le titre

            `'content' => $this->faker->sentences(rand(2, 3)),`

            faker a des functions ressemblante sentence et sentences, l'un pour les mots et l'autres pour les paragraphes!

!! ne pas oublier de preciser pour les champs boolean une valeur par default false ou true au cas ou!
!!    `protected $guarded = []; ` il faut le rajouter dans chaque Model pour autoriser faker a remplir les champs sinon la protection de laravel s'active


## seeder a la database
dans database/seeder, il y a un fichier qui permet de lancer la generation des factory!!!

 `   public function run()
    {
        $tags = \App\Models\Tag::factory(8)->create();
        $user = \App\Models\User::factory(10)->create()->each(function($user) use ($tags){
            \App\Models\Event::factory(rand(2, 6))->create([
                'user_id' => $user->id,
            ])->each(function($event) use ($tags)

        {
$event->tags()->attach($tags->random(3));
        });
        });

    }
`

la function est un peu compliquer car elle se fit a ce que nous lui avons indiqué, elle créé les users, qui peuvent créer un nombre d'évenements et qui eux même sont liés aux tags

pour lancer l'ensemble de nos tables creer pour injecter dans la database mysql ou postgres mongodb.. il faut faire
`php artisan migrate --seed` , --seed lance notre fichier seed pour faker

## routes
ne pas oublier que pour lister les routes il suffit de taper la commande `php artisan route:liste`

## controller

recuperation des events dans l'index de celui ci nous voulons uniquement les evenements presents et a venir, les evenements finient ne doivent pas etre affiche sur cette page!
donc un where starts-at qui est superieur a now ou egale
        $events = event::where('starts_at', '>', now());

on recupere les relations dans un tableau, array car il y en a plusieurs ->with(['user', 'tags'])

## view
{{!$loop->last ? ',', ''}}  est une function de laravel, permet d'indiquer les characteres separateur notamment pour les tags et de looper et quand il n'y a plus rien, on ne met plus de virgule

nous pouvons dans le controller, afficher les evenements dans l'ordre ->orderBy('starts_at','asc')

## proteger les pages
la function middleware permet de bloquer les pages au sein du controller 
`        $this->middleware('auth');` ici la class auth, on peut y mettre un tableau [] et lui passer des options
        `    'only' => ['create', 'store'] ` elle est active uniquement sur les functions create et store

## accès routes
si vous voulez voir des routes specifiques `php artisan route:liste --name=NAME`

## creation form input
ne pas oublier dans method `@crsf` qui est la method de laravel pour proteger l'envoi de données
pour afficher un calendrier il suffit que dans le input a type, on indique `date`

## fetch store
nous passons par la function store, avec un dd($request) nous voyons qu'il envoi bien toute nos donnees!
dans le controller store, il faut indiquer les liaisons avec la database
'premium' => $request->filled('premium'), l'option filled permet de mettre une valeur boolean (true or false), si elle est coché, elle passe à true car d'origine elle est à false

pour retirer les espaces dans une serie de mot ou phrase on utilise la function trim($variable)
       ` $inputTag = trim($inputTag); `


creer un  tag si il n'existe pas
        $tag = Tag::firstOrCreate([
'slug' => Str::slug($inputTag)
        ], [
            'name' => $inputTag
        ]);

        $event->tags()->attach($tag->id);
    }
return redirect()->route('event.index');

    }

c'est la function firstOrCreate qui permet comme un if de specifier si il faut creer `str::slug regarde si il existe sinon 'name' => $inputTag;

ensuite il faut le creer, il faut faire la function attach pour l'attacher à un id $tag->id

Puis on retourne à la page souhaité, une fois le formulaire soumis redirect()->route('nameofroute')

## sauvegarde de key api ou autre
on peut stocker dans notre fichier .env des key en indiquant une variable que l'on desire PAYPAL_KEY = Zefrt

la librairie cashier de laravel permet de creer des options de paiement facilement
`composer require laravel/cashier`

pour appeler une variable d'environnement dans une view
    `const stripe = Stripe('{{env('STRIPE_KEY')}}');`


 `       $authed_user = auth()->user();
$amount = 1000;

if($request->filled('premium')) $amount += 500;

$authed_user->charge($amount, $request->payment_method);
`

cette condition permet de dire si la checkbox premium est coché il faut rajouter 500 à amount
ensuite avec charge on envoit au site stripe le montant 500 avec payment_method de la librairie stripe!
