<?php declare(strict_types = 1);

// odsl-C:\xampp\htdocs\touche-pas-au-klaxon\src\Controllers\AuthController.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Controllers\AuthController
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.1-8.2.12-416673b485b6fb4d16cc4b738933f243f72bf44e143d86c87bf236ee08305da9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Controllers\\AuthController',
        'filename' => 'C:/xampp/htdocs/touche-pas-au-klaxon/src/Controllers/AuthController.php',
      ),
    ),
    'namespace' => 'App\\Controllers',
    'name' => 'App\\Controllers\\AuthController',
    'shortName' => 'AuthController',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * Class AuthController
 *
 * Gère l\'authentification des utilisateurs :
 * - affichage du formulaire de connexion
 * - traitement de la connexion
 * - déconnexion
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 15,
    'endLine' => 91,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'App\\Controllers\\CoreController',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
    ),
    'immediateMethods' => 
    array (
      '__construct' => 
      array (
        'name' => '__construct',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Initialise les protections globales via CoreController.
 */',
        'startLine' => 20,
        'endLine' => 23,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\AuthController',
        'implementingClassName' => 'App\\Controllers\\AuthController',
        'currentClassName' => 'App\\Controllers\\AuthController',
        'aliasName' => NULL,
      ),
      'loginForm' => 
      array (
        'name' => 'loginForm',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Affiche le formulaire de connexion.
 *
 * @return void
 */',
        'startLine' => 30,
        'endLine' => 33,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\AuthController',
        'implementingClassName' => 'App\\Controllers\\AuthController',
        'currentClassName' => 'App\\Controllers\\AuthController',
        'aliasName' => NULL,
      ),
      'login' => 
      array (
        'name' => 'login',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Traite la tentative de connexion.
 *
 * Vérifie :
 * - que les champs sont remplis
 * - que l\'utilisateur existe
 * - que le mot de passe est correct
 *
 * Redirige :
 * - admin → tableau de bord
 * - utilisateur → accueil
 *
 * @return void
 */',
        'startLine' => 49,
        'endLine' => 78,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\AuthController',
        'implementingClassName' => 'App\\Controllers\\AuthController',
        'currentClassName' => 'App\\Controllers\\AuthController',
        'aliasName' => NULL,
      ),
      'logout' => 
      array (
        'name' => 'logout',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Déconnecte l\'utilisateur et détruit la session.
 *
 * @return void
 */',
        'startLine' => 85,
        'endLine' => 90,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\AuthController',
        'implementingClassName' => 'App\\Controllers\\AuthController',
        'currentClassName' => 'App\\Controllers\\AuthController',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));