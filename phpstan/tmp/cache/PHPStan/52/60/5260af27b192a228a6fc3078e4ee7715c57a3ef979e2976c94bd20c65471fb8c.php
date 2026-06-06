<?php declare(strict_types = 1);

// odsl-C:\xampp\htdocs\touche-pas-au-klaxon\src\Controllers\TripController.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Controllers\TripController
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.1-8.2.12-07442cfd26100c1743c71b487e3040842916a551698a914b4ef335660e89b1b2',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Controllers\\TripController',
        'filename' => 'C:/xampp/htdocs/touche-pas-au-klaxon/src/Controllers/TripController.php',
      ),
    ),
    'namespace' => 'App\\Controllers',
    'name' => 'App\\Controllers\\TripController',
    'shortName' => 'TripController',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * Class TripController
 *
 * Gère toutes les opérations liées aux trajets :
 * - liste publique filtrée
 * - affichage d\'un trajet
 * - création
 * - modification
 * - suppression
 *
 * Les actions sensibles nécessitent une authentification.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 21,
    'endLine' => 302,
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
        'startLine' => 26,
        'endLine' => 29,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\TripController',
        'implementingClassName' => 'App\\Controllers\\TripController',
        'currentClassName' => 'App\\Controllers\\TripController',
        'aliasName' => NULL,
      ),
      'index' => 
      array (
        'name' => 'index',
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
 * Affiche la liste des trajets publics filtrés.
 *
 * Filtres possibles :
 * - departure (ID agence)
 * - arrival (ID agence)
 * - date (YYYY-MM-DD)
 *
 * @return void
 */',
        'startLine' => 41,
        'endLine' => 60,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\TripController',
        'implementingClassName' => 'App\\Controllers\\TripController',
        'currentClassName' => 'App\\Controllers\\TripController',
        'aliasName' => NULL,
      ),
      'show' => 
      array (
        'name' => 'show',
        'parameters' => 
        array (
          'id' => 
          array (
            'name' => 'id',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 68,
            'endLine' => 68,
            'startColumn' => 26,
            'endColumn' => 32,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
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
 * Affiche les détails d\'un trajet.
 *
 * @param int $id ID du trajet
 * @return void
 */',
        'startLine' => 68,
        'endLine' => 82,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\TripController',
        'implementingClassName' => 'App\\Controllers\\TripController',
        'currentClassName' => 'App\\Controllers\\TripController',
        'aliasName' => NULL,
      ),
      'createForm' => 
      array (
        'name' => 'createForm',
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
 * Affiche le formulaire de création d\'un trajet.
 *
 * @return void
 */',
        'startLine' => 89,
        'endLine' => 97,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\TripController',
        'implementingClassName' => 'App\\Controllers\\TripController',
        'currentClassName' => 'App\\Controllers\\TripController',
        'aliasName' => NULL,
      ),
      'create' => 
      array (
        'name' => 'create',
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
 * Traite la création d\'un trajet.
 *
 * Effectue les contrôles :
 * - agences différentes
 * - dates cohérentes
 * - nombre de places valide
 *
 * @return void
 */',
        'startLine' => 109,
        'endLine' => 154,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\TripController',
        'implementingClassName' => 'App\\Controllers\\TripController',
        'currentClassName' => 'App\\Controllers\\TripController',
        'aliasName' => NULL,
      ),
      'editForm' => 
      array (
        'name' => 'editForm',
        'parameters' => 
        array (
          'id' => 
          array (
            'name' => 'id',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 166,
            'endLine' => 166,
            'startColumn' => 30,
            'endColumn' => 36,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
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
 * Affiche le formulaire d\'édition d\'un trajet.
 *
 * Vérifie :
 * - que le trajet existe
 * - que l\'utilisateur est l\'auteur ou admin
 *
 * @param int $id ID du trajet
 * @return void
 */',
        'startLine' => 166,
        'endLine' => 193,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\TripController',
        'implementingClassName' => 'App\\Controllers\\TripController',
        'currentClassName' => 'App\\Controllers\\TripController',
        'aliasName' => NULL,
      ),
      'update' => 
      array (
        'name' => 'update',
        'parameters' => 
        array (
          'id' => 
          array (
            'name' => 'id',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 206,
            'endLine' => 206,
            'startColumn' => 28,
            'endColumn' => 34,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
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
 * Met à jour un trajet existant.
 *
 * Vérifie :
 * - cohérence des agences
 * - cohérence des dates
 * - cohérence des places
 *
 * @param int $id ID du trajet
 * @return void
 */',
        'startLine' => 206,
        'endLine' => 265,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\TripController',
        'implementingClassName' => 'App\\Controllers\\TripController',
        'currentClassName' => 'App\\Controllers\\TripController',
        'aliasName' => NULL,
      ),
      'delete' => 
      array (
        'name' => 'delete',
        'parameters' => 
        array (
          'id' => 
          array (
            'name' => 'id',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 277,
            'endLine' => 277,
            'startColumn' => 28,
            'endColumn' => 34,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
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
 * Supprime un trajet.
 *
 * Vérifie :
 * - que le trajet existe
 * - que l\'utilisateur est l\'auteur ou admin
 *
 * @param int $id ID du trajet
 * @return void
 */',
        'startLine' => 277,
        'endLine' => 301,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Controllers',
        'declaringClassName' => 'App\\Controllers\\TripController',
        'implementingClassName' => 'App\\Controllers\\TripController',
        'currentClassName' => 'App\\Controllers\\TripController',
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