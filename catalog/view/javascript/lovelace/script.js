/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/core-js/internals/a-function.js":
/*!******************************************************!*\
  !*** ./node_modules/core-js/internals/a-function.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') {
    throw TypeError(String(it) + ' is not a function');
  } return it;
};


/***/ }),

/***/ "./node_modules/core-js/internals/a-possible-prototype.js":
/*!****************************************************************!*\
  !*** ./node_modules/core-js/internals/a-possible-prototype.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");

module.exports = function (it) {
  if (!isObject(it) && it !== null) {
    throw TypeError("Can't set " + String(it) + ' as a prototype');
  } return it;
};


/***/ }),

/***/ "./node_modules/core-js/internals/advance-string-index.js":
/*!****************************************************************!*\
  !*** ./node_modules/core-js/internals/advance-string-index.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var charAt = __webpack_require__(/*! ../internals/string-multibyte */ "./node_modules/core-js/internals/string-multibyte.js").charAt;

// `AdvanceStringIndex` abstract operation
// https://tc39.es/ecma262/#sec-advancestringindex
module.exports = function (S, index, unicode) {
  return index + (unicode ? charAt(S, index).length : 1);
};


/***/ }),

/***/ "./node_modules/core-js/internals/an-object.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/an-object.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");

module.exports = function (it) {
  if (!isObject(it)) {
    throw TypeError(String(it) + ' is not an object');
  } return it;
};


/***/ }),

/***/ "./node_modules/core-js/internals/array-for-each.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/internals/array-for-each.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $forEach = __webpack_require__(/*! ../internals/array-iteration */ "./node_modules/core-js/internals/array-iteration.js").forEach;
var arrayMethodIsStrict = __webpack_require__(/*! ../internals/array-method-is-strict */ "./node_modules/core-js/internals/array-method-is-strict.js");

var STRICT_METHOD = arrayMethodIsStrict('forEach');

// `Array.prototype.forEach` method implementation
// https://tc39.es/ecma262/#sec-array.prototype.foreach
module.exports = !STRICT_METHOD ? function forEach(callbackfn /* , thisArg */) {
  return $forEach(this, callbackfn, arguments.length > 1 ? arguments[1] : undefined);
// eslint-disable-next-line es/no-array-prototype-foreach -- safe
} : [].forEach;


/***/ }),

/***/ "./node_modules/core-js/internals/array-includes.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/internals/array-includes.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var toIndexedObject = __webpack_require__(/*! ../internals/to-indexed-object */ "./node_modules/core-js/internals/to-indexed-object.js");
var toLength = __webpack_require__(/*! ../internals/to-length */ "./node_modules/core-js/internals/to-length.js");
var toAbsoluteIndex = __webpack_require__(/*! ../internals/to-absolute-index */ "./node_modules/core-js/internals/to-absolute-index.js");

// `Array.prototype.{ indexOf, includes }` methods implementation
var createMethod = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIndexedObject($this);
    var length = toLength(O.length);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare -- NaN check
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare -- NaN check
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) {
      if ((IS_INCLUDES || index in O) && O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};

module.exports = {
  // `Array.prototype.includes` method
  // https://tc39.es/ecma262/#sec-array.prototype.includes
  includes: createMethod(true),
  // `Array.prototype.indexOf` method
  // https://tc39.es/ecma262/#sec-array.prototype.indexof
  indexOf: createMethod(false)
};


/***/ }),

/***/ "./node_modules/core-js/internals/array-iteration.js":
/*!***********************************************************!*\
  !*** ./node_modules/core-js/internals/array-iteration.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var bind = __webpack_require__(/*! ../internals/function-bind-context */ "./node_modules/core-js/internals/function-bind-context.js");
var IndexedObject = __webpack_require__(/*! ../internals/indexed-object */ "./node_modules/core-js/internals/indexed-object.js");
var toObject = __webpack_require__(/*! ../internals/to-object */ "./node_modules/core-js/internals/to-object.js");
var toLength = __webpack_require__(/*! ../internals/to-length */ "./node_modules/core-js/internals/to-length.js");
var arraySpeciesCreate = __webpack_require__(/*! ../internals/array-species-create */ "./node_modules/core-js/internals/array-species-create.js");

var push = [].push;

// `Array.prototype.{ forEach, map, filter, some, every, find, findIndex, filterOut }` methods implementation
var createMethod = function (TYPE) {
  var IS_MAP = TYPE == 1;
  var IS_FILTER = TYPE == 2;
  var IS_SOME = TYPE == 3;
  var IS_EVERY = TYPE == 4;
  var IS_FIND_INDEX = TYPE == 6;
  var IS_FILTER_OUT = TYPE == 7;
  var NO_HOLES = TYPE == 5 || IS_FIND_INDEX;
  return function ($this, callbackfn, that, specificCreate) {
    var O = toObject($this);
    var self = IndexedObject(O);
    var boundFunction = bind(callbackfn, that, 3);
    var length = toLength(self.length);
    var index = 0;
    var create = specificCreate || arraySpeciesCreate;
    var target = IS_MAP ? create($this, length) : IS_FILTER || IS_FILTER_OUT ? create($this, 0) : undefined;
    var value, result;
    for (;length > index; index++) if (NO_HOLES || index in self) {
      value = self[index];
      result = boundFunction(value, index, O);
      if (TYPE) {
        if (IS_MAP) target[index] = result; // map
        else if (result) switch (TYPE) {
          case 3: return true;              // some
          case 5: return value;             // find
          case 6: return index;             // findIndex
          case 2: push.call(target, value); // filter
        } else switch (TYPE) {
          case 4: return false;             // every
          case 7: push.call(target, value); // filterOut
        }
      }
    }
    return IS_FIND_INDEX ? -1 : IS_SOME || IS_EVERY ? IS_EVERY : target;
  };
};

module.exports = {
  // `Array.prototype.forEach` method
  // https://tc39.es/ecma262/#sec-array.prototype.foreach
  forEach: createMethod(0),
  // `Array.prototype.map` method
  // https://tc39.es/ecma262/#sec-array.prototype.map
  map: createMethod(1),
  // `Array.prototype.filter` method
  // https://tc39.es/ecma262/#sec-array.prototype.filter
  filter: createMethod(2),
  // `Array.prototype.some` method
  // https://tc39.es/ecma262/#sec-array.prototype.some
  some: createMethod(3),
  // `Array.prototype.every` method
  // https://tc39.es/ecma262/#sec-array.prototype.every
  every: createMethod(4),
  // `Array.prototype.find` method
  // https://tc39.es/ecma262/#sec-array.prototype.find
  find: createMethod(5),
  // `Array.prototype.findIndex` method
  // https://tc39.es/ecma262/#sec-array.prototype.findIndex
  findIndex: createMethod(6),
  // `Array.prototype.filterOut` method
  // https://github.com/tc39/proposal-array-filtering
  filterOut: createMethod(7)
};


/***/ }),

/***/ "./node_modules/core-js/internals/array-method-has-species-support.js":
/*!****************************************************************************!*\
  !*** ./node_modules/core-js/internals/array-method-has-species-support.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var wellKnownSymbol = __webpack_require__(/*! ../internals/well-known-symbol */ "./node_modules/core-js/internals/well-known-symbol.js");
var V8_VERSION = __webpack_require__(/*! ../internals/engine-v8-version */ "./node_modules/core-js/internals/engine-v8-version.js");

var SPECIES = wellKnownSymbol('species');

module.exports = function (METHOD_NAME) {
  // We can't use this feature detection in V8 since it causes
  // deoptimization and serious performance degradation
  // https://github.com/zloirock/core-js/issues/677
  return V8_VERSION >= 51 || !fails(function () {
    var array = [];
    var constructor = array.constructor = {};
    constructor[SPECIES] = function () {
      return { foo: 1 };
    };
    return array[METHOD_NAME](Boolean).foo !== 1;
  });
};


/***/ }),

/***/ "./node_modules/core-js/internals/array-method-is-strict.js":
/*!******************************************************************!*\
  !*** ./node_modules/core-js/internals/array-method-is-strict.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");

module.exports = function (METHOD_NAME, argument) {
  var method = [][METHOD_NAME];
  return !!method && fails(function () {
    // eslint-disable-next-line no-useless-call,no-throw-literal -- required for testing
    method.call(null, argument || function () { throw 1; }, 1);
  });
};


/***/ }),

/***/ "./node_modules/core-js/internals/array-species-create.js":
/*!****************************************************************!*\
  !*** ./node_modules/core-js/internals/array-species-create.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");
var isArray = __webpack_require__(/*! ../internals/is-array */ "./node_modules/core-js/internals/is-array.js");
var wellKnownSymbol = __webpack_require__(/*! ../internals/well-known-symbol */ "./node_modules/core-js/internals/well-known-symbol.js");

var SPECIES = wellKnownSymbol('species');

// `ArraySpeciesCreate` abstract operation
// https://tc39.es/ecma262/#sec-arrayspeciescreate
module.exports = function (originalArray, length) {
  var C;
  if (isArray(originalArray)) {
    C = originalArray.constructor;
    // cross-realm fallback
    if (typeof C == 'function' && (C === Array || isArray(C.prototype))) C = undefined;
    else if (isObject(C)) {
      C = C[SPECIES];
      if (C === null) C = undefined;
    }
  } return new (C === undefined ? Array : C)(length === 0 ? 0 : length);
};


/***/ }),

/***/ "./node_modules/core-js/internals/classof-raw.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/classof-raw.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),

/***/ "./node_modules/core-js/internals/copy-constructor-properties.js":
/*!***********************************************************************!*\
  !*** ./node_modules/core-js/internals/copy-constructor-properties.js ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__(/*! ../internals/has */ "./node_modules/core-js/internals/has.js");
var ownKeys = __webpack_require__(/*! ../internals/own-keys */ "./node_modules/core-js/internals/own-keys.js");
var getOwnPropertyDescriptorModule = __webpack_require__(/*! ../internals/object-get-own-property-descriptor */ "./node_modules/core-js/internals/object-get-own-property-descriptor.js");
var definePropertyModule = __webpack_require__(/*! ../internals/object-define-property */ "./node_modules/core-js/internals/object-define-property.js");

module.exports = function (target, source) {
  var keys = ownKeys(source);
  var defineProperty = definePropertyModule.f;
  var getOwnPropertyDescriptor = getOwnPropertyDescriptorModule.f;
  for (var i = 0; i < keys.length; i++) {
    var key = keys[i];
    if (!has(target, key)) defineProperty(target, key, getOwnPropertyDescriptor(source, key));
  }
};


/***/ }),

/***/ "./node_modules/core-js/internals/create-non-enumerable-property.js":
/*!**************************************************************************!*\
  !*** ./node_modules/core-js/internals/create-non-enumerable-property.js ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var definePropertyModule = __webpack_require__(/*! ../internals/object-define-property */ "./node_modules/core-js/internals/object-define-property.js");
var createPropertyDescriptor = __webpack_require__(/*! ../internals/create-property-descriptor */ "./node_modules/core-js/internals/create-property-descriptor.js");

module.exports = DESCRIPTORS ? function (object, key, value) {
  return definePropertyModule.f(object, key, createPropertyDescriptor(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),

/***/ "./node_modules/core-js/internals/create-property-descriptor.js":
/*!**********************************************************************!*\
  !*** ./node_modules/core-js/internals/create-property-descriptor.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),

/***/ "./node_modules/core-js/internals/create-property.js":
/*!***********************************************************!*\
  !*** ./node_modules/core-js/internals/create-property.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var toPrimitive = __webpack_require__(/*! ../internals/to-primitive */ "./node_modules/core-js/internals/to-primitive.js");
var definePropertyModule = __webpack_require__(/*! ../internals/object-define-property */ "./node_modules/core-js/internals/object-define-property.js");
var createPropertyDescriptor = __webpack_require__(/*! ../internals/create-property-descriptor */ "./node_modules/core-js/internals/create-property-descriptor.js");

module.exports = function (object, key, value) {
  var propertyKey = toPrimitive(key);
  if (propertyKey in object) definePropertyModule.f(object, propertyKey, createPropertyDescriptor(0, value));
  else object[propertyKey] = value;
};


/***/ }),

/***/ "./node_modules/core-js/internals/descriptors.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/descriptors.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");

// Detect IE8's incomplete defineProperty implementation
module.exports = !fails(function () {
  // eslint-disable-next-line es/no-object-defineproperty -- required for testing
  return Object.defineProperty({}, 1, { get: function () { return 7; } })[1] != 7;
});


/***/ }),

/***/ "./node_modules/core-js/internals/document-create-element.js":
/*!*******************************************************************!*\
  !*** ./node_modules/core-js/internals/document-create-element.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");

var document = global.document;
// typeof document.createElement is 'object' in old IE
var EXISTS = isObject(document) && isObject(document.createElement);

module.exports = function (it) {
  return EXISTS ? document.createElement(it) : {};
};


/***/ }),

/***/ "./node_modules/core-js/internals/dom-iterables.js":
/*!*********************************************************!*\
  !*** ./node_modules/core-js/internals/dom-iterables.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// iterable DOM collections
// flag - `iterable` interface - 'entries', 'keys', 'values', 'forEach' methods
module.exports = {
  CSSRuleList: 0,
  CSSStyleDeclaration: 0,
  CSSValueList: 0,
  ClientRectList: 0,
  DOMRectList: 0,
  DOMStringList: 0,
  DOMTokenList: 1,
  DataTransferItemList: 0,
  FileList: 0,
  HTMLAllCollection: 0,
  HTMLCollection: 0,
  HTMLFormElement: 0,
  HTMLSelectElement: 0,
  MediaList: 0,
  MimeTypeArray: 0,
  NamedNodeMap: 0,
  NodeList: 1,
  PaintRequestList: 0,
  Plugin: 0,
  PluginArray: 0,
  SVGLengthList: 0,
  SVGNumberList: 0,
  SVGPathSegList: 0,
  SVGPointList: 0,
  SVGStringList: 0,
  SVGTransformList: 0,
  SourceBufferList: 0,
  StyleSheetList: 0,
  TextTrackCueList: 0,
  TextTrackList: 0,
  TouchList: 0
};


/***/ }),

/***/ "./node_modules/core-js/internals/engine-user-agent.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/internals/engine-user-agent.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var getBuiltIn = __webpack_require__(/*! ../internals/get-built-in */ "./node_modules/core-js/internals/get-built-in.js");

module.exports = getBuiltIn('navigator', 'userAgent') || '';


/***/ }),

/***/ "./node_modules/core-js/internals/engine-v8-version.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/internals/engine-v8-version.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var userAgent = __webpack_require__(/*! ../internals/engine-user-agent */ "./node_modules/core-js/internals/engine-user-agent.js");

var process = global.process;
var versions = process && process.versions;
var v8 = versions && versions.v8;
var match, version;

if (v8) {
  match = v8.split('.');
  version = match[0] < 4 ? 1 : match[0] + match[1];
} else if (userAgent) {
  match = userAgent.match(/Edge\/(\d+)/);
  if (!match || match[1] >= 74) {
    match = userAgent.match(/Chrome\/(\d+)/);
    if (match) version = match[1];
  }
}

module.exports = version && +version;


/***/ }),

/***/ "./node_modules/core-js/internals/enum-bug-keys.js":
/*!*********************************************************!*\
  !*** ./node_modules/core-js/internals/enum-bug-keys.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// IE8- don't enum bug keys
module.exports = [
  'constructor',
  'hasOwnProperty',
  'isPrototypeOf',
  'propertyIsEnumerable',
  'toLocaleString',
  'toString',
  'valueOf'
];


/***/ }),

/***/ "./node_modules/core-js/internals/export.js":
/*!**************************************************!*\
  !*** ./node_modules/core-js/internals/export.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var getOwnPropertyDescriptor = __webpack_require__(/*! ../internals/object-get-own-property-descriptor */ "./node_modules/core-js/internals/object-get-own-property-descriptor.js").f;
var createNonEnumerableProperty = __webpack_require__(/*! ../internals/create-non-enumerable-property */ "./node_modules/core-js/internals/create-non-enumerable-property.js");
var redefine = __webpack_require__(/*! ../internals/redefine */ "./node_modules/core-js/internals/redefine.js");
var setGlobal = __webpack_require__(/*! ../internals/set-global */ "./node_modules/core-js/internals/set-global.js");
var copyConstructorProperties = __webpack_require__(/*! ../internals/copy-constructor-properties */ "./node_modules/core-js/internals/copy-constructor-properties.js");
var isForced = __webpack_require__(/*! ../internals/is-forced */ "./node_modules/core-js/internals/is-forced.js");

/*
  options.target      - name of the target object
  options.global      - target is the global object
  options.stat        - export as static methods of target
  options.proto       - export as prototype methods of target
  options.real        - real prototype method for the `pure` version
  options.forced      - export even if the native feature is available
  options.bind        - bind methods to the target, required for the `pure` version
  options.wrap        - wrap constructors to preventing global pollution, required for the `pure` version
  options.unsafe      - use the simple assignment of property instead of delete + defineProperty
  options.sham        - add a flag to not completely full polyfills
  options.enumerable  - export as enumerable property
  options.noTargetGet - prevent calling a getter on target
*/
module.exports = function (options, source) {
  var TARGET = options.target;
  var GLOBAL = options.global;
  var STATIC = options.stat;
  var FORCED, target, key, targetProperty, sourceProperty, descriptor;
  if (GLOBAL) {
    target = global;
  } else if (STATIC) {
    target = global[TARGET] || setGlobal(TARGET, {});
  } else {
    target = (global[TARGET] || {}).prototype;
  }
  if (target) for (key in source) {
    sourceProperty = source[key];
    if (options.noTargetGet) {
      descriptor = getOwnPropertyDescriptor(target, key);
      targetProperty = descriptor && descriptor.value;
    } else targetProperty = target[key];
    FORCED = isForced(GLOBAL ? key : TARGET + (STATIC ? '.' : '#') + key, options.forced);
    // contained in target
    if (!FORCED && targetProperty !== undefined) {
      if (typeof sourceProperty === typeof targetProperty) continue;
      copyConstructorProperties(sourceProperty, targetProperty);
    }
    // add a flag to not completely full polyfills
    if (options.sham || (targetProperty && targetProperty.sham)) {
      createNonEnumerableProperty(sourceProperty, 'sham', true);
    }
    // extend global
    redefine(target, key, sourceProperty, options);
  }
};


/***/ }),

/***/ "./node_modules/core-js/internals/fails.js":
/*!*************************************************!*\
  !*** ./node_modules/core-js/internals/fails.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (error) {
    return true;
  }
};


/***/ }),

/***/ "./node_modules/core-js/internals/fix-regexp-well-known-symbol-logic.js":
/*!******************************************************************************!*\
  !*** ./node_modules/core-js/internals/fix-regexp-well-known-symbol-logic.js ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// TODO: Remove from `core-js@4` since it's moved to entry points
__webpack_require__(/*! ../modules/es.regexp.exec */ "./node_modules/core-js/modules/es.regexp.exec.js");
var redefine = __webpack_require__(/*! ../internals/redefine */ "./node_modules/core-js/internals/redefine.js");
var regexpExec = __webpack_require__(/*! ../internals/regexp-exec */ "./node_modules/core-js/internals/regexp-exec.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var wellKnownSymbol = __webpack_require__(/*! ../internals/well-known-symbol */ "./node_modules/core-js/internals/well-known-symbol.js");
var createNonEnumerableProperty = __webpack_require__(/*! ../internals/create-non-enumerable-property */ "./node_modules/core-js/internals/create-non-enumerable-property.js");

var SPECIES = wellKnownSymbol('species');
var RegExpPrototype = RegExp.prototype;

var REPLACE_SUPPORTS_NAMED_GROUPS = !fails(function () {
  // #replace needs built-in support for named groups.
  // #match works fine because it just return the exec results, even if it has
  // a "grops" property.
  var re = /./;
  re.exec = function () {
    var result = [];
    result.groups = { a: '7' };
    return result;
  };
  return ''.replace(re, '$<a>') !== '7';
});

// IE <= 11 replaces $0 with the whole match, as if it was $&
// https://stackoverflow.com/questions/6024666/getting-ie-to-replace-a-regex-with-the-literal-string-0
var REPLACE_KEEPS_$0 = (function () {
  // eslint-disable-next-line regexp/prefer-escape-replacement-dollar-char -- required for testing
  return 'a'.replace(/./, '$0') === '$0';
})();

var REPLACE = wellKnownSymbol('replace');
// Safari <= 13.0.3(?) substitutes nth capture where n>m with an empty string
var REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE = (function () {
  if (/./[REPLACE]) {
    return /./[REPLACE]('a', '$0') === '';
  }
  return false;
})();

// Chrome 51 has a buggy "split" implementation when RegExp#exec !== nativeExec
// Weex JS has frozen built-in prototypes, so use try / catch wrapper
var SPLIT_WORKS_WITH_OVERWRITTEN_EXEC = !fails(function () {
  // eslint-disable-next-line regexp/no-empty-group -- required for testing
  var re = /(?:)/;
  var originalExec = re.exec;
  re.exec = function () { return originalExec.apply(this, arguments); };
  var result = 'ab'.split(re);
  return result.length !== 2 || result[0] !== 'a' || result[1] !== 'b';
});

module.exports = function (KEY, length, exec, sham) {
  var SYMBOL = wellKnownSymbol(KEY);

  var DELEGATES_TO_SYMBOL = !fails(function () {
    // String methods call symbol-named RegEp methods
    var O = {};
    O[SYMBOL] = function () { return 7; };
    return ''[KEY](O) != 7;
  });

  var DELEGATES_TO_EXEC = DELEGATES_TO_SYMBOL && !fails(function () {
    // Symbol-named RegExp methods call .exec
    var execCalled = false;
    var re = /a/;

    if (KEY === 'split') {
      // We can't use real regex here since it causes deoptimization
      // and serious performance degradation in V8
      // https://github.com/zloirock/core-js/issues/306
      re = {};
      // RegExp[@@split] doesn't call the regex's exec method, but first creates
      // a new one. We need to return the patched regex when creating the new one.
      re.constructor = {};
      re.constructor[SPECIES] = function () { return re; };
      re.flags = '';
      re[SYMBOL] = /./[SYMBOL];
    }

    re.exec = function () { execCalled = true; return null; };

    re[SYMBOL]('');
    return !execCalled;
  });

  if (
    !DELEGATES_TO_SYMBOL ||
    !DELEGATES_TO_EXEC ||
    (KEY === 'replace' && !(
      REPLACE_SUPPORTS_NAMED_GROUPS &&
      REPLACE_KEEPS_$0 &&
      !REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE
    )) ||
    (KEY === 'split' && !SPLIT_WORKS_WITH_OVERWRITTEN_EXEC)
  ) {
    var nativeRegExpMethod = /./[SYMBOL];
    var methods = exec(SYMBOL, ''[KEY], function (nativeMethod, regexp, str, arg2, forceStringMethod) {
      var $exec = regexp.exec;
      if ($exec === regexpExec || $exec === RegExpPrototype.exec) {
        if (DELEGATES_TO_SYMBOL && !forceStringMethod) {
          // The native String method already delegates to @@method (this
          // polyfilled function), leasing to infinite recursion.
          // We avoid it by directly calling the native @@method method.
          return { done: true, value: nativeRegExpMethod.call(regexp, str, arg2) };
        }
        return { done: true, value: nativeMethod.call(str, regexp, arg2) };
      }
      return { done: false };
    }, {
      REPLACE_KEEPS_$0: REPLACE_KEEPS_$0,
      REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE: REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE
    });
    var stringMethod = methods[0];
    var regexMethod = methods[1];

    redefine(String.prototype, KEY, stringMethod);
    redefine(RegExpPrototype, SYMBOL, length == 2
      // 21.2.5.8 RegExp.prototype[@@replace](string, replaceValue)
      // 21.2.5.11 RegExp.prototype[@@split](string, limit)
      ? function (string, arg) { return regexMethod.call(string, this, arg); }
      // 21.2.5.6 RegExp.prototype[@@match](string)
      // 21.2.5.9 RegExp.prototype[@@search](string)
      : function (string) { return regexMethod.call(string, this); }
    );
  }

  if (sham) createNonEnumerableProperty(RegExpPrototype[SYMBOL], 'sham', true);
};


/***/ }),

/***/ "./node_modules/core-js/internals/function-bind-context.js":
/*!*****************************************************************!*\
  !*** ./node_modules/core-js/internals/function-bind-context.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var aFunction = __webpack_require__(/*! ../internals/a-function */ "./node_modules/core-js/internals/a-function.js");

// optional / simple context binding
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 0: return function () {
      return fn.call(that);
    };
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),

/***/ "./node_modules/core-js/internals/get-built-in.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/internals/get-built-in.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var path = __webpack_require__(/*! ../internals/path */ "./node_modules/core-js/internals/path.js");
var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");

var aFunction = function (variable) {
  return typeof variable == 'function' ? variable : undefined;
};

module.exports = function (namespace, method) {
  return arguments.length < 2 ? aFunction(path[namespace]) || aFunction(global[namespace])
    : path[namespace] && path[namespace][method] || global[namespace] && global[namespace][method];
};


/***/ }),

/***/ "./node_modules/core-js/internals/get-substitution.js":
/*!************************************************************!*\
  !*** ./node_modules/core-js/internals/get-substitution.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var toObject = __webpack_require__(/*! ../internals/to-object */ "./node_modules/core-js/internals/to-object.js");

var floor = Math.floor;
var replace = ''.replace;
var SUBSTITUTION_SYMBOLS = /\$([$&'`]|\d{1,2}|<[^>]*>)/g;
var SUBSTITUTION_SYMBOLS_NO_NAMED = /\$([$&'`]|\d{1,2})/g;

// `GetSubstitution` abstract operation
// https://tc39.es/ecma262/#sec-getsubstitution
module.exports = function (matched, str, position, captures, namedCaptures, replacement) {
  var tailPos = position + matched.length;
  var m = captures.length;
  var symbols = SUBSTITUTION_SYMBOLS_NO_NAMED;
  if (namedCaptures !== undefined) {
    namedCaptures = toObject(namedCaptures);
    symbols = SUBSTITUTION_SYMBOLS;
  }
  return replace.call(replacement, symbols, function (match, ch) {
    var capture;
    switch (ch.charAt(0)) {
      case '$': return '$';
      case '&': return matched;
      case '`': return str.slice(0, position);
      case "'": return str.slice(tailPos);
      case '<':
        capture = namedCaptures[ch.slice(1, -1)];
        break;
      default: // \d\d?
        var n = +ch;
        if (n === 0) return match;
        if (n > m) {
          var f = floor(n / 10);
          if (f === 0) return match;
          if (f <= m) return captures[f - 1] === undefined ? ch.charAt(1) : captures[f - 1] + ch.charAt(1);
          return match;
        }
        capture = captures[n - 1];
    }
    return capture === undefined ? '' : capture;
  });
};


/***/ }),

/***/ "./node_modules/core-js/internals/global.js":
/*!**************************************************!*\
  !*** ./node_modules/core-js/internals/global.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var check = function (it) {
  return it && it.Math == Math && it;
};

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
module.exports =
  // eslint-disable-next-line es/no-global-this -- safe
  check(typeof globalThis == 'object' && globalThis) ||
  check(typeof window == 'object' && window) ||
  // eslint-disable-next-line no-restricted-globals -- safe
  check(typeof self == 'object' && self) ||
  check(typeof global == 'object' && global) ||
  // eslint-disable-next-line no-new-func -- fallback
  (function () { return this; })() || Function('return this')();

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/core-js/internals/has.js":
/*!***********************************************!*\
  !*** ./node_modules/core-js/internals/has.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var toObject = __webpack_require__(/*! ../internals/to-object */ "./node_modules/core-js/internals/to-object.js");

var hasOwnProperty = {}.hasOwnProperty;

module.exports = Object.hasOwn || function hasOwn(it, key) {
  return hasOwnProperty.call(toObject(it), key);
};


/***/ }),

/***/ "./node_modules/core-js/internals/hidden-keys.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/hidden-keys.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = {};


/***/ }),

/***/ "./node_modules/core-js/internals/ie8-dom-define.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/internals/ie8-dom-define.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var createElement = __webpack_require__(/*! ../internals/document-create-element */ "./node_modules/core-js/internals/document-create-element.js");

// Thank's IE8 for his funny defineProperty
module.exports = !DESCRIPTORS && !fails(function () {
  // eslint-disable-next-line es/no-object-defineproperty -- requied for testing
  return Object.defineProperty(createElement('div'), 'a', {
    get: function () { return 7; }
  }).a != 7;
});


/***/ }),

/***/ "./node_modules/core-js/internals/indexed-object.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/internals/indexed-object.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var classof = __webpack_require__(/*! ../internals/classof-raw */ "./node_modules/core-js/internals/classof-raw.js");

var split = ''.split;

// fallback for non-array-like ES3 and non-enumerable old V8 strings
module.exports = fails(function () {
  // throws an error in rhino, see https://github.com/mozilla/rhino/issues/346
  // eslint-disable-next-line no-prototype-builtins -- safe
  return !Object('z').propertyIsEnumerable(0);
}) ? function (it) {
  return classof(it) == 'String' ? split.call(it, '') : Object(it);
} : Object;


/***/ }),

/***/ "./node_modules/core-js/internals/inherit-if-required.js":
/*!***************************************************************!*\
  !*** ./node_modules/core-js/internals/inherit-if-required.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");
var setPrototypeOf = __webpack_require__(/*! ../internals/object-set-prototype-of */ "./node_modules/core-js/internals/object-set-prototype-of.js");

// makes subclassing work correct for wrapped built-ins
module.exports = function ($this, dummy, Wrapper) {
  var NewTarget, NewTargetPrototype;
  if (
    // it can work only with native `setPrototypeOf`
    setPrototypeOf &&
    // we haven't completely correct pre-ES6 way for getting `new.target`, so use this
    typeof (NewTarget = dummy.constructor) == 'function' &&
    NewTarget !== Wrapper &&
    isObject(NewTargetPrototype = NewTarget.prototype) &&
    NewTargetPrototype !== Wrapper.prototype
  ) setPrototypeOf($this, NewTargetPrototype);
  return $this;
};


/***/ }),

/***/ "./node_modules/core-js/internals/inspect-source.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/internals/inspect-source.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var store = __webpack_require__(/*! ../internals/shared-store */ "./node_modules/core-js/internals/shared-store.js");

var functionToString = Function.toString;

// this helper broken in `core-js@3.4.1-3.4.4`, so we can't use `shared` helper
if (typeof store.inspectSource != 'function') {
  store.inspectSource = function (it) {
    return functionToString.call(it);
  };
}

module.exports = store.inspectSource;


/***/ }),

/***/ "./node_modules/core-js/internals/internal-state.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/internals/internal-state.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var NATIVE_WEAK_MAP = __webpack_require__(/*! ../internals/native-weak-map */ "./node_modules/core-js/internals/native-weak-map.js");
var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");
var createNonEnumerableProperty = __webpack_require__(/*! ../internals/create-non-enumerable-property */ "./node_modules/core-js/internals/create-non-enumerable-property.js");
var objectHas = __webpack_require__(/*! ../internals/has */ "./node_modules/core-js/internals/has.js");
var shared = __webpack_require__(/*! ../internals/shared-store */ "./node_modules/core-js/internals/shared-store.js");
var sharedKey = __webpack_require__(/*! ../internals/shared-key */ "./node_modules/core-js/internals/shared-key.js");
var hiddenKeys = __webpack_require__(/*! ../internals/hidden-keys */ "./node_modules/core-js/internals/hidden-keys.js");

var OBJECT_ALREADY_INITIALIZED = 'Object already initialized';
var WeakMap = global.WeakMap;
var set, get, has;

var enforce = function (it) {
  return has(it) ? get(it) : set(it, {});
};

var getterFor = function (TYPE) {
  return function (it) {
    var state;
    if (!isObject(it) || (state = get(it)).type !== TYPE) {
      throw TypeError('Incompatible receiver, ' + TYPE + ' required');
    } return state;
  };
};

if (NATIVE_WEAK_MAP || shared.state) {
  var store = shared.state || (shared.state = new WeakMap());
  var wmget = store.get;
  var wmhas = store.has;
  var wmset = store.set;
  set = function (it, metadata) {
    if (wmhas.call(store, it)) throw new TypeError(OBJECT_ALREADY_INITIALIZED);
    metadata.facade = it;
    wmset.call(store, it, metadata);
    return metadata;
  };
  get = function (it) {
    return wmget.call(store, it) || {};
  };
  has = function (it) {
    return wmhas.call(store, it);
  };
} else {
  var STATE = sharedKey('state');
  hiddenKeys[STATE] = true;
  set = function (it, metadata) {
    if (objectHas(it, STATE)) throw new TypeError(OBJECT_ALREADY_INITIALIZED);
    metadata.facade = it;
    createNonEnumerableProperty(it, STATE, metadata);
    return metadata;
  };
  get = function (it) {
    return objectHas(it, STATE) ? it[STATE] : {};
  };
  has = function (it) {
    return objectHas(it, STATE);
  };
}

module.exports = {
  set: set,
  get: get,
  has: has,
  enforce: enforce,
  getterFor: getterFor
};


/***/ }),

/***/ "./node_modules/core-js/internals/is-array.js":
/*!****************************************************!*\
  !*** ./node_modules/core-js/internals/is-array.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var classof = __webpack_require__(/*! ../internals/classof-raw */ "./node_modules/core-js/internals/classof-raw.js");

// `IsArray` abstract operation
// https://tc39.es/ecma262/#sec-isarray
// eslint-disable-next-line es/no-array-isarray -- safe
module.exports = Array.isArray || function isArray(arg) {
  return classof(arg) == 'Array';
};


/***/ }),

/***/ "./node_modules/core-js/internals/is-forced.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/is-forced.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");

var replacement = /#|\.prototype\./;

var isForced = function (feature, detection) {
  var value = data[normalize(feature)];
  return value == POLYFILL ? true
    : value == NATIVE ? false
    : typeof detection == 'function' ? fails(detection)
    : !!detection;
};

var normalize = isForced.normalize = function (string) {
  return String(string).replace(replacement, '.').toLowerCase();
};

var data = isForced.data = {};
var NATIVE = isForced.NATIVE = 'N';
var POLYFILL = isForced.POLYFILL = 'P';

module.exports = isForced;


/***/ }),

/***/ "./node_modules/core-js/internals/is-object.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/is-object.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),

/***/ "./node_modules/core-js/internals/is-pure.js":
/*!***************************************************!*\
  !*** ./node_modules/core-js/internals/is-pure.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = false;


/***/ }),

/***/ "./node_modules/core-js/internals/is-regexp.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/is-regexp.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");
var classof = __webpack_require__(/*! ../internals/classof-raw */ "./node_modules/core-js/internals/classof-raw.js");
var wellKnownSymbol = __webpack_require__(/*! ../internals/well-known-symbol */ "./node_modules/core-js/internals/well-known-symbol.js");

var MATCH = wellKnownSymbol('match');

// `IsRegExp` abstract operation
// https://tc39.es/ecma262/#sec-isregexp
module.exports = function (it) {
  var isRegExp;
  return isObject(it) && ((isRegExp = it[MATCH]) !== undefined ? !!isRegExp : classof(it) == 'RegExp');
};


/***/ }),

/***/ "./node_modules/core-js/internals/native-symbol.js":
/*!*********************************************************!*\
  !*** ./node_modules/core-js/internals/native-symbol.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* eslint-disable es/no-symbol -- required for testing */
var V8_VERSION = __webpack_require__(/*! ../internals/engine-v8-version */ "./node_modules/core-js/internals/engine-v8-version.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");

// eslint-disable-next-line es/no-object-getownpropertysymbols -- required for testing
module.exports = !!Object.getOwnPropertySymbols && !fails(function () {
  var symbol = Symbol();
  // Chrome 38 Symbol has incorrect toString conversion
  // `get-own-property-symbols` polyfill symbols converted to object are not Symbol instances
  return !String(symbol) || !(Object(symbol) instanceof Symbol) ||
    // Chrome 38-40 symbols are not inherited from DOM collections prototypes to instances
    !Symbol.sham && V8_VERSION && V8_VERSION < 41;
});


/***/ }),

/***/ "./node_modules/core-js/internals/native-weak-map.js":
/*!***********************************************************!*\
  !*** ./node_modules/core-js/internals/native-weak-map.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var inspectSource = __webpack_require__(/*! ../internals/inspect-source */ "./node_modules/core-js/internals/inspect-source.js");

var WeakMap = global.WeakMap;

module.exports = typeof WeakMap === 'function' && /native code/.test(inspectSource(WeakMap));


/***/ }),

/***/ "./node_modules/core-js/internals/number-parse-float.js":
/*!**************************************************************!*\
  !*** ./node_modules/core-js/internals/number-parse-float.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var trim = __webpack_require__(/*! ../internals/string-trim */ "./node_modules/core-js/internals/string-trim.js").trim;
var whitespaces = __webpack_require__(/*! ../internals/whitespaces */ "./node_modules/core-js/internals/whitespaces.js");

var $parseFloat = global.parseFloat;
var FORCED = 1 / $parseFloat(whitespaces + '-0') !== -Infinity;

// `parseFloat` method
// https://tc39.es/ecma262/#sec-parsefloat-string
module.exports = FORCED ? function parseFloat(string) {
  var trimmedString = trim(String(string));
  var result = $parseFloat(trimmedString);
  return result === 0 && trimmedString.charAt(0) == '-' ? -0 : result;
} : $parseFloat;


/***/ }),

/***/ "./node_modules/core-js/internals/object-define-property.js":
/*!******************************************************************!*\
  !*** ./node_modules/core-js/internals/object-define-property.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var IE8_DOM_DEFINE = __webpack_require__(/*! ../internals/ie8-dom-define */ "./node_modules/core-js/internals/ie8-dom-define.js");
var anObject = __webpack_require__(/*! ../internals/an-object */ "./node_modules/core-js/internals/an-object.js");
var toPrimitive = __webpack_require__(/*! ../internals/to-primitive */ "./node_modules/core-js/internals/to-primitive.js");

// eslint-disable-next-line es/no-object-defineproperty -- safe
var $defineProperty = Object.defineProperty;

// `Object.defineProperty` method
// https://tc39.es/ecma262/#sec-object.defineproperty
exports.f = DESCRIPTORS ? $defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return $defineProperty(O, P, Attributes);
  } catch (error) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),

/***/ "./node_modules/core-js/internals/object-get-own-property-descriptor.js":
/*!******************************************************************************!*\
  !*** ./node_modules/core-js/internals/object-get-own-property-descriptor.js ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var propertyIsEnumerableModule = __webpack_require__(/*! ../internals/object-property-is-enumerable */ "./node_modules/core-js/internals/object-property-is-enumerable.js");
var createPropertyDescriptor = __webpack_require__(/*! ../internals/create-property-descriptor */ "./node_modules/core-js/internals/create-property-descriptor.js");
var toIndexedObject = __webpack_require__(/*! ../internals/to-indexed-object */ "./node_modules/core-js/internals/to-indexed-object.js");
var toPrimitive = __webpack_require__(/*! ../internals/to-primitive */ "./node_modules/core-js/internals/to-primitive.js");
var has = __webpack_require__(/*! ../internals/has */ "./node_modules/core-js/internals/has.js");
var IE8_DOM_DEFINE = __webpack_require__(/*! ../internals/ie8-dom-define */ "./node_modules/core-js/internals/ie8-dom-define.js");

// eslint-disable-next-line es/no-object-getownpropertydescriptor -- safe
var $getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;

// `Object.getOwnPropertyDescriptor` method
// https://tc39.es/ecma262/#sec-object.getownpropertydescriptor
exports.f = DESCRIPTORS ? $getOwnPropertyDescriptor : function getOwnPropertyDescriptor(O, P) {
  O = toIndexedObject(O);
  P = toPrimitive(P, true);
  if (IE8_DOM_DEFINE) try {
    return $getOwnPropertyDescriptor(O, P);
  } catch (error) { /* empty */ }
  if (has(O, P)) return createPropertyDescriptor(!propertyIsEnumerableModule.f.call(O, P), O[P]);
};


/***/ }),

/***/ "./node_modules/core-js/internals/object-get-own-property-names.js":
/*!*************************************************************************!*\
  !*** ./node_modules/core-js/internals/object-get-own-property-names.js ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var internalObjectKeys = __webpack_require__(/*! ../internals/object-keys-internal */ "./node_modules/core-js/internals/object-keys-internal.js");
var enumBugKeys = __webpack_require__(/*! ../internals/enum-bug-keys */ "./node_modules/core-js/internals/enum-bug-keys.js");

var hiddenKeys = enumBugKeys.concat('length', 'prototype');

// `Object.getOwnPropertyNames` method
// https://tc39.es/ecma262/#sec-object.getownpropertynames
// eslint-disable-next-line es/no-object-getownpropertynames -- safe
exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O) {
  return internalObjectKeys(O, hiddenKeys);
};


/***/ }),

/***/ "./node_modules/core-js/internals/object-get-own-property-symbols.js":
/*!***************************************************************************!*\
  !*** ./node_modules/core-js/internals/object-get-own-property-symbols.js ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// eslint-disable-next-line es/no-object-getownpropertysymbols -- safe
exports.f = Object.getOwnPropertySymbols;


/***/ }),

/***/ "./node_modules/core-js/internals/object-keys-internal.js":
/*!****************************************************************!*\
  !*** ./node_modules/core-js/internals/object-keys-internal.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__(/*! ../internals/has */ "./node_modules/core-js/internals/has.js");
var toIndexedObject = __webpack_require__(/*! ../internals/to-indexed-object */ "./node_modules/core-js/internals/to-indexed-object.js");
var indexOf = __webpack_require__(/*! ../internals/array-includes */ "./node_modules/core-js/internals/array-includes.js").indexOf;
var hiddenKeys = __webpack_require__(/*! ../internals/hidden-keys */ "./node_modules/core-js/internals/hidden-keys.js");

module.exports = function (object, names) {
  var O = toIndexedObject(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) !has(hiddenKeys, key) && has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (has(O, key = names[i++])) {
    ~indexOf(result, key) || result.push(key);
  }
  return result;
};


/***/ }),

/***/ "./node_modules/core-js/internals/object-keys.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/object-keys.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var internalObjectKeys = __webpack_require__(/*! ../internals/object-keys-internal */ "./node_modules/core-js/internals/object-keys-internal.js");
var enumBugKeys = __webpack_require__(/*! ../internals/enum-bug-keys */ "./node_modules/core-js/internals/enum-bug-keys.js");

// `Object.keys` method
// https://tc39.es/ecma262/#sec-object.keys
// eslint-disable-next-line es/no-object-keys -- safe
module.exports = Object.keys || function keys(O) {
  return internalObjectKeys(O, enumBugKeys);
};


/***/ }),

/***/ "./node_modules/core-js/internals/object-property-is-enumerable.js":
/*!*************************************************************************!*\
  !*** ./node_modules/core-js/internals/object-property-is-enumerable.js ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $propertyIsEnumerable = {}.propertyIsEnumerable;
// eslint-disable-next-line es/no-object-getownpropertydescriptor -- safe
var getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;

// Nashorn ~ JDK8 bug
var NASHORN_BUG = getOwnPropertyDescriptor && !$propertyIsEnumerable.call({ 1: 2 }, 1);

// `Object.prototype.propertyIsEnumerable` method implementation
// https://tc39.es/ecma262/#sec-object.prototype.propertyisenumerable
exports.f = NASHORN_BUG ? function propertyIsEnumerable(V) {
  var descriptor = getOwnPropertyDescriptor(this, V);
  return !!descriptor && descriptor.enumerable;
} : $propertyIsEnumerable;


/***/ }),

/***/ "./node_modules/core-js/internals/object-set-prototype-of.js":
/*!*******************************************************************!*\
  !*** ./node_modules/core-js/internals/object-set-prototype-of.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* eslint-disable no-proto -- safe */
var anObject = __webpack_require__(/*! ../internals/an-object */ "./node_modules/core-js/internals/an-object.js");
var aPossiblePrototype = __webpack_require__(/*! ../internals/a-possible-prototype */ "./node_modules/core-js/internals/a-possible-prototype.js");

// `Object.setPrototypeOf` method
// https://tc39.es/ecma262/#sec-object.setprototypeof
// Works with __proto__ only. Old v8 can't work with null proto objects.
// eslint-disable-next-line es/no-object-setprototypeof -- safe
module.exports = Object.setPrototypeOf || ('__proto__' in {} ? function () {
  var CORRECT_SETTER = false;
  var test = {};
  var setter;
  try {
    // eslint-disable-next-line es/no-object-getownpropertydescriptor -- safe
    setter = Object.getOwnPropertyDescriptor(Object.prototype, '__proto__').set;
    setter.call(test, []);
    CORRECT_SETTER = test instanceof Array;
  } catch (error) { /* empty */ }
  return function setPrototypeOf(O, proto) {
    anObject(O);
    aPossiblePrototype(proto);
    if (CORRECT_SETTER) setter.call(O, proto);
    else O.__proto__ = proto;
    return O;
  };
}() : undefined);


/***/ }),

/***/ "./node_modules/core-js/internals/object-to-array.js":
/*!***********************************************************!*\
  !*** ./node_modules/core-js/internals/object-to-array.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var objectKeys = __webpack_require__(/*! ../internals/object-keys */ "./node_modules/core-js/internals/object-keys.js");
var toIndexedObject = __webpack_require__(/*! ../internals/to-indexed-object */ "./node_modules/core-js/internals/to-indexed-object.js");
var propertyIsEnumerable = __webpack_require__(/*! ../internals/object-property-is-enumerable */ "./node_modules/core-js/internals/object-property-is-enumerable.js").f;

// `Object.{ entries, values }` methods implementation
var createMethod = function (TO_ENTRIES) {
  return function (it) {
    var O = toIndexedObject(it);
    var keys = objectKeys(O);
    var length = keys.length;
    var i = 0;
    var result = [];
    var key;
    while (length > i) {
      key = keys[i++];
      if (!DESCRIPTORS || propertyIsEnumerable.call(O, key)) {
        result.push(TO_ENTRIES ? [key, O[key]] : O[key]);
      }
    }
    return result;
  };
};

module.exports = {
  // `Object.entries` method
  // https://tc39.es/ecma262/#sec-object.entries
  entries: createMethod(true),
  // `Object.values` method
  // https://tc39.es/ecma262/#sec-object.values
  values: createMethod(false)
};


/***/ }),

/***/ "./node_modules/core-js/internals/own-keys.js":
/*!****************************************************!*\
  !*** ./node_modules/core-js/internals/own-keys.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var getBuiltIn = __webpack_require__(/*! ../internals/get-built-in */ "./node_modules/core-js/internals/get-built-in.js");
var getOwnPropertyNamesModule = __webpack_require__(/*! ../internals/object-get-own-property-names */ "./node_modules/core-js/internals/object-get-own-property-names.js");
var getOwnPropertySymbolsModule = __webpack_require__(/*! ../internals/object-get-own-property-symbols */ "./node_modules/core-js/internals/object-get-own-property-symbols.js");
var anObject = __webpack_require__(/*! ../internals/an-object */ "./node_modules/core-js/internals/an-object.js");

// all object keys, includes non-enumerable and symbols
module.exports = getBuiltIn('Reflect', 'ownKeys') || function ownKeys(it) {
  var keys = getOwnPropertyNamesModule.f(anObject(it));
  var getOwnPropertySymbols = getOwnPropertySymbolsModule.f;
  return getOwnPropertySymbols ? keys.concat(getOwnPropertySymbols(it)) : keys;
};


/***/ }),

/***/ "./node_modules/core-js/internals/path.js":
/*!************************************************!*\
  !*** ./node_modules/core-js/internals/path.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");

module.exports = global;


/***/ }),

/***/ "./node_modules/core-js/internals/redefine.js":
/*!****************************************************!*\
  !*** ./node_modules/core-js/internals/redefine.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var createNonEnumerableProperty = __webpack_require__(/*! ../internals/create-non-enumerable-property */ "./node_modules/core-js/internals/create-non-enumerable-property.js");
var has = __webpack_require__(/*! ../internals/has */ "./node_modules/core-js/internals/has.js");
var setGlobal = __webpack_require__(/*! ../internals/set-global */ "./node_modules/core-js/internals/set-global.js");
var inspectSource = __webpack_require__(/*! ../internals/inspect-source */ "./node_modules/core-js/internals/inspect-source.js");
var InternalStateModule = __webpack_require__(/*! ../internals/internal-state */ "./node_modules/core-js/internals/internal-state.js");

var getInternalState = InternalStateModule.get;
var enforceInternalState = InternalStateModule.enforce;
var TEMPLATE = String(String).split('String');

(module.exports = function (O, key, value, options) {
  var unsafe = options ? !!options.unsafe : false;
  var simple = options ? !!options.enumerable : false;
  var noTargetGet = options ? !!options.noTargetGet : false;
  var state;
  if (typeof value == 'function') {
    if (typeof key == 'string' && !has(value, 'name')) {
      createNonEnumerableProperty(value, 'name', key);
    }
    state = enforceInternalState(value);
    if (!state.source) {
      state.source = TEMPLATE.join(typeof key == 'string' ? key : '');
    }
  }
  if (O === global) {
    if (simple) O[key] = value;
    else setGlobal(key, value);
    return;
  } else if (!unsafe) {
    delete O[key];
  } else if (!noTargetGet && O[key]) {
    simple = true;
  }
  if (simple) O[key] = value;
  else createNonEnumerableProperty(O, key, value);
// add fake Function#toString for correct work wrapped methods / constructors with methods like LoDash isNative
})(Function.prototype, 'toString', function toString() {
  return typeof this == 'function' && getInternalState(this).source || inspectSource(this);
});


/***/ }),

/***/ "./node_modules/core-js/internals/regexp-exec-abstract.js":
/*!****************************************************************!*\
  !*** ./node_modules/core-js/internals/regexp-exec-abstract.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var classof = __webpack_require__(/*! ./classof-raw */ "./node_modules/core-js/internals/classof-raw.js");
var regexpExec = __webpack_require__(/*! ./regexp-exec */ "./node_modules/core-js/internals/regexp-exec.js");

// `RegExpExec` abstract operation
// https://tc39.es/ecma262/#sec-regexpexec
module.exports = function (R, S) {
  var exec = R.exec;
  if (typeof exec === 'function') {
    var result = exec.call(R, S);
    if (typeof result !== 'object') {
      throw TypeError('RegExp exec method returned something other than an Object or null');
    }
    return result;
  }

  if (classof(R) !== 'RegExp') {
    throw TypeError('RegExp#exec called on incompatible receiver');
  }

  return regexpExec.call(R, S);
};



/***/ }),

/***/ "./node_modules/core-js/internals/regexp-exec.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/regexp-exec.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/* eslint-disable regexp/no-assertion-capturing-group, regexp/no-empty-group, regexp/no-lazy-ends -- testing */
/* eslint-disable regexp/no-useless-quantifier -- testing */
var regexpFlags = __webpack_require__(/*! ./regexp-flags */ "./node_modules/core-js/internals/regexp-flags.js");
var stickyHelpers = __webpack_require__(/*! ./regexp-sticky-helpers */ "./node_modules/core-js/internals/regexp-sticky-helpers.js");
var shared = __webpack_require__(/*! ./shared */ "./node_modules/core-js/internals/shared.js");

var nativeExec = RegExp.prototype.exec;
var nativeReplace = shared('native-string-replace', String.prototype.replace);

var patchedExec = nativeExec;

var UPDATES_LAST_INDEX_WRONG = (function () {
  var re1 = /a/;
  var re2 = /b*/g;
  nativeExec.call(re1, 'a');
  nativeExec.call(re2, 'a');
  return re1.lastIndex !== 0 || re2.lastIndex !== 0;
})();

var UNSUPPORTED_Y = stickyHelpers.UNSUPPORTED_Y || stickyHelpers.BROKEN_CARET;

// nonparticipating capturing group, copied from es5-shim's String#split patch.
var NPCG_INCLUDED = /()??/.exec('')[1] !== undefined;

var PATCH = UPDATES_LAST_INDEX_WRONG || NPCG_INCLUDED || UNSUPPORTED_Y;

if (PATCH) {
  patchedExec = function exec(str) {
    var re = this;
    var lastIndex, reCopy, match, i;
    var sticky = UNSUPPORTED_Y && re.sticky;
    var flags = regexpFlags.call(re);
    var source = re.source;
    var charsAdded = 0;
    var strCopy = str;

    if (sticky) {
      flags = flags.replace('y', '');
      if (flags.indexOf('g') === -1) {
        flags += 'g';
      }

      strCopy = String(str).slice(re.lastIndex);
      // Support anchored sticky behavior.
      if (re.lastIndex > 0 && (!re.multiline || re.multiline && str[re.lastIndex - 1] !== '\n')) {
        source = '(?: ' + source + ')';
        strCopy = ' ' + strCopy;
        charsAdded++;
      }
      // ^(? + rx + ) is needed, in combination with some str slicing, to
      // simulate the 'y' flag.
      reCopy = new RegExp('^(?:' + source + ')', flags);
    }

    if (NPCG_INCLUDED) {
      reCopy = new RegExp('^' + source + '$(?!\\s)', flags);
    }
    if (UPDATES_LAST_INDEX_WRONG) lastIndex = re.lastIndex;

    match = nativeExec.call(sticky ? reCopy : re, strCopy);

    if (sticky) {
      if (match) {
        match.input = match.input.slice(charsAdded);
        match[0] = match[0].slice(charsAdded);
        match.index = re.lastIndex;
        re.lastIndex += match[0].length;
      } else re.lastIndex = 0;
    } else if (UPDATES_LAST_INDEX_WRONG && match) {
      re.lastIndex = re.global ? match.index + match[0].length : lastIndex;
    }
    if (NPCG_INCLUDED && match && match.length > 1) {
      // Fix browsers whose `exec` methods don't consistently return `undefined`
      // for NPCG, like IE8. NOTE: This doesn' work for /(.?)?/
      nativeReplace.call(match[0], reCopy, function () {
        for (i = 1; i < arguments.length - 2; i++) {
          if (arguments[i] === undefined) match[i] = undefined;
        }
      });
    }

    return match;
  };
}

module.exports = patchedExec;


/***/ }),

/***/ "./node_modules/core-js/internals/regexp-flags.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/internals/regexp-flags.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var anObject = __webpack_require__(/*! ../internals/an-object */ "./node_modules/core-js/internals/an-object.js");

// `RegExp.prototype.flags` getter implementation
// https://tc39.es/ecma262/#sec-get-regexp.prototype.flags
module.exports = function () {
  var that = anObject(this);
  var result = '';
  if (that.global) result += 'g';
  if (that.ignoreCase) result += 'i';
  if (that.multiline) result += 'm';
  if (that.dotAll) result += 's';
  if (that.unicode) result += 'u';
  if (that.sticky) result += 'y';
  return result;
};


/***/ }),

/***/ "./node_modules/core-js/internals/regexp-sticky-helpers.js":
/*!*****************************************************************!*\
  !*** ./node_modules/core-js/internals/regexp-sticky-helpers.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var fails = __webpack_require__(/*! ./fails */ "./node_modules/core-js/internals/fails.js");

// babel-minify transpiles RegExp('a', 'y') -> /a/y and it causes SyntaxError,
// so we use an intermediate function.
function RE(s, f) {
  return RegExp(s, f);
}

exports.UNSUPPORTED_Y = fails(function () {
  // babel-minify transpiles RegExp('a', 'y') -> /a/y and it causes SyntaxError
  var re = RE('a', 'y');
  re.lastIndex = 2;
  return re.exec('abcd') != null;
});

exports.BROKEN_CARET = fails(function () {
  // https://bugzilla.mozilla.org/show_bug.cgi?id=773687
  var re = RE('^r', 'gy');
  re.lastIndex = 2;
  return re.exec('str') != null;
});


/***/ }),

/***/ "./node_modules/core-js/internals/require-object-coercible.js":
/*!********************************************************************!*\
  !*** ./node_modules/core-js/internals/require-object-coercible.js ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// `RequireObjectCoercible` abstract operation
// https://tc39.es/ecma262/#sec-requireobjectcoercible
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on " + it);
  return it;
};


/***/ }),

/***/ "./node_modules/core-js/internals/set-global.js":
/*!******************************************************!*\
  !*** ./node_modules/core-js/internals/set-global.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var createNonEnumerableProperty = __webpack_require__(/*! ../internals/create-non-enumerable-property */ "./node_modules/core-js/internals/create-non-enumerable-property.js");

module.exports = function (key, value) {
  try {
    createNonEnumerableProperty(global, key, value);
  } catch (error) {
    global[key] = value;
  } return value;
};


/***/ }),

/***/ "./node_modules/core-js/internals/set-species.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/set-species.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var getBuiltIn = __webpack_require__(/*! ../internals/get-built-in */ "./node_modules/core-js/internals/get-built-in.js");
var definePropertyModule = __webpack_require__(/*! ../internals/object-define-property */ "./node_modules/core-js/internals/object-define-property.js");
var wellKnownSymbol = __webpack_require__(/*! ../internals/well-known-symbol */ "./node_modules/core-js/internals/well-known-symbol.js");
var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");

var SPECIES = wellKnownSymbol('species');

module.exports = function (CONSTRUCTOR_NAME) {
  var Constructor = getBuiltIn(CONSTRUCTOR_NAME);
  var defineProperty = definePropertyModule.f;

  if (DESCRIPTORS && Constructor && !Constructor[SPECIES]) {
    defineProperty(Constructor, SPECIES, {
      configurable: true,
      get: function () { return this; }
    });
  }
};


/***/ }),

/***/ "./node_modules/core-js/internals/shared-key.js":
/*!******************************************************!*\
  !*** ./node_modules/core-js/internals/shared-key.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var shared = __webpack_require__(/*! ../internals/shared */ "./node_modules/core-js/internals/shared.js");
var uid = __webpack_require__(/*! ../internals/uid */ "./node_modules/core-js/internals/uid.js");

var keys = shared('keys');

module.exports = function (key) {
  return keys[key] || (keys[key] = uid(key));
};


/***/ }),

/***/ "./node_modules/core-js/internals/shared-store.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/internals/shared-store.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var setGlobal = __webpack_require__(/*! ../internals/set-global */ "./node_modules/core-js/internals/set-global.js");

var SHARED = '__core-js_shared__';
var store = global[SHARED] || setGlobal(SHARED, {});

module.exports = store;


/***/ }),

/***/ "./node_modules/core-js/internals/shared.js":
/*!**************************************************!*\
  !*** ./node_modules/core-js/internals/shared.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var IS_PURE = __webpack_require__(/*! ../internals/is-pure */ "./node_modules/core-js/internals/is-pure.js");
var store = __webpack_require__(/*! ../internals/shared-store */ "./node_modules/core-js/internals/shared-store.js");

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: '3.14.0',
  mode: IS_PURE ? 'pure' : 'global',
  copyright: '© 2021 Denis Pushkarev (zloirock.ru)'
});


/***/ }),

/***/ "./node_modules/core-js/internals/string-multibyte.js":
/*!************************************************************!*\
  !*** ./node_modules/core-js/internals/string-multibyte.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(/*! ../internals/to-integer */ "./node_modules/core-js/internals/to-integer.js");
var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");

// `String.prototype.{ codePointAt, at }` methods implementation
var createMethod = function (CONVERT_TO_STRING) {
  return function ($this, pos) {
    var S = String(requireObjectCoercible($this));
    var position = toInteger(pos);
    var size = S.length;
    var first, second;
    if (position < 0 || position >= size) return CONVERT_TO_STRING ? '' : undefined;
    first = S.charCodeAt(position);
    return first < 0xD800 || first > 0xDBFF || position + 1 === size
      || (second = S.charCodeAt(position + 1)) < 0xDC00 || second > 0xDFFF
        ? CONVERT_TO_STRING ? S.charAt(position) : first
        : CONVERT_TO_STRING ? S.slice(position, position + 2) : (first - 0xD800 << 10) + (second - 0xDC00) + 0x10000;
  };
};

module.exports = {
  // `String.prototype.codePointAt` method
  // https://tc39.es/ecma262/#sec-string.prototype.codepointat
  codeAt: createMethod(false),
  // `String.prototype.at` method
  // https://github.com/mathiasbynens/String.prototype.at
  charAt: createMethod(true)
};


/***/ }),

/***/ "./node_modules/core-js/internals/string-repeat.js":
/*!*********************************************************!*\
  !*** ./node_modules/core-js/internals/string-repeat.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var toInteger = __webpack_require__(/*! ../internals/to-integer */ "./node_modules/core-js/internals/to-integer.js");
var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");

// `String.prototype.repeat` method implementation
// https://tc39.es/ecma262/#sec-string.prototype.repeat
module.exports = function repeat(count) {
  var str = String(requireObjectCoercible(this));
  var result = '';
  var n = toInteger(count);
  if (n < 0 || n == Infinity) throw RangeError('Wrong number of repetitions');
  for (;n > 0; (n >>>= 1) && (str += str)) if (n & 1) result += str;
  return result;
};


/***/ }),

/***/ "./node_modules/core-js/internals/string-trim-forced.js":
/*!**************************************************************!*\
  !*** ./node_modules/core-js/internals/string-trim-forced.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var whitespaces = __webpack_require__(/*! ../internals/whitespaces */ "./node_modules/core-js/internals/whitespaces.js");

var non = '\u200B\u0085\u180E';

// check that a method works with the correct list
// of whitespaces and has a correct name
module.exports = function (METHOD_NAME) {
  return fails(function () {
    return !!whitespaces[METHOD_NAME]() || non[METHOD_NAME]() != non || whitespaces[METHOD_NAME].name !== METHOD_NAME;
  });
};


/***/ }),

/***/ "./node_modules/core-js/internals/string-trim.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/string-trim.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");
var whitespaces = __webpack_require__(/*! ../internals/whitespaces */ "./node_modules/core-js/internals/whitespaces.js");

var whitespace = '[' + whitespaces + ']';
var ltrim = RegExp('^' + whitespace + whitespace + '*');
var rtrim = RegExp(whitespace + whitespace + '*$');

// `String.prototype.{ trim, trimStart, trimEnd, trimLeft, trimRight }` methods implementation
var createMethod = function (TYPE) {
  return function ($this) {
    var string = String(requireObjectCoercible($this));
    if (TYPE & 1) string = string.replace(ltrim, '');
    if (TYPE & 2) string = string.replace(rtrim, '');
    return string;
  };
};

module.exports = {
  // `String.prototype.{ trimLeft, trimStart }` methods
  // https://tc39.es/ecma262/#sec-string.prototype.trimstart
  start: createMethod(1),
  // `String.prototype.{ trimRight, trimEnd }` methods
  // https://tc39.es/ecma262/#sec-string.prototype.trimend
  end: createMethod(2),
  // `String.prototype.trim` method
  // https://tc39.es/ecma262/#sec-string.prototype.trim
  trim: createMethod(3)
};


/***/ }),

/***/ "./node_modules/core-js/internals/this-number-value.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/internals/this-number-value.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var classof = __webpack_require__(/*! ../internals/classof-raw */ "./node_modules/core-js/internals/classof-raw.js");

// `thisNumberValue` abstract operation
// https://tc39.es/ecma262/#sec-thisnumbervalue
module.exports = function (value) {
  if (typeof value != 'number' && classof(value) != 'Number') {
    throw TypeError('Incorrect invocation');
  }
  return +value;
};


/***/ }),

/***/ "./node_modules/core-js/internals/to-absolute-index.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/internals/to-absolute-index.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(/*! ../internals/to-integer */ "./node_modules/core-js/internals/to-integer.js");

var max = Math.max;
var min = Math.min;

// Helper for a popular repeating case of the spec:
// Let integer be ? ToInteger(index).
// If integer < 0, let result be max((length + integer), 0); else let result be min(integer, length).
module.exports = function (index, length) {
  var integer = toInteger(index);
  return integer < 0 ? max(integer + length, 0) : min(integer, length);
};


/***/ }),

/***/ "./node_modules/core-js/internals/to-indexed-object.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/internals/to-indexed-object.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// toObject with fallback for non-array-like ES3 strings
var IndexedObject = __webpack_require__(/*! ../internals/indexed-object */ "./node_modules/core-js/internals/indexed-object.js");
var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");

module.exports = function (it) {
  return IndexedObject(requireObjectCoercible(it));
};


/***/ }),

/***/ "./node_modules/core-js/internals/to-integer.js":
/*!******************************************************!*\
  !*** ./node_modules/core-js/internals/to-integer.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var ceil = Math.ceil;
var floor = Math.floor;

// `ToInteger` abstract operation
// https://tc39.es/ecma262/#sec-tointeger
module.exports = function (argument) {
  return isNaN(argument = +argument) ? 0 : (argument > 0 ? floor : ceil)(argument);
};


/***/ }),

/***/ "./node_modules/core-js/internals/to-length.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/to-length.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(/*! ../internals/to-integer */ "./node_modules/core-js/internals/to-integer.js");

var min = Math.min;

// `ToLength` abstract operation
// https://tc39.es/ecma262/#sec-tolength
module.exports = function (argument) {
  return argument > 0 ? min(toInteger(argument), 0x1FFFFFFFFFFFFF) : 0; // 2 ** 53 - 1 == 9007199254740991
};


/***/ }),

/***/ "./node_modules/core-js/internals/to-object.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/to-object.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");

// `ToObject` abstract operation
// https://tc39.es/ecma262/#sec-toobject
module.exports = function (argument) {
  return Object(requireObjectCoercible(argument));
};


/***/ }),

/***/ "./node_modules/core-js/internals/to-primitive.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/internals/to-primitive.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");

// `ToPrimitive` abstract operation
// https://tc39.es/ecma262/#sec-toprimitive
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (input, PREFERRED_STRING) {
  if (!isObject(input)) return input;
  var fn, val;
  if (PREFERRED_STRING && typeof (fn = input.toString) == 'function' && !isObject(val = fn.call(input))) return val;
  if (typeof (fn = input.valueOf) == 'function' && !isObject(val = fn.call(input))) return val;
  if (!PREFERRED_STRING && typeof (fn = input.toString) == 'function' && !isObject(val = fn.call(input))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),

/***/ "./node_modules/core-js/internals/uid.js":
/*!***********************************************!*\
  !*** ./node_modules/core-js/internals/uid.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var id = 0;
var postfix = Math.random();

module.exports = function (key) {
  return 'Symbol(' + String(key === undefined ? '' : key) + ')_' + (++id + postfix).toString(36);
};


/***/ }),

/***/ "./node_modules/core-js/internals/use-symbol-as-uid.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/internals/use-symbol-as-uid.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* eslint-disable es/no-symbol -- required for testing */
var NATIVE_SYMBOL = __webpack_require__(/*! ../internals/native-symbol */ "./node_modules/core-js/internals/native-symbol.js");

module.exports = NATIVE_SYMBOL
  && !Symbol.sham
  && typeof Symbol.iterator == 'symbol';


/***/ }),

/***/ "./node_modules/core-js/internals/well-known-symbol.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/internals/well-known-symbol.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var shared = __webpack_require__(/*! ../internals/shared */ "./node_modules/core-js/internals/shared.js");
var has = __webpack_require__(/*! ../internals/has */ "./node_modules/core-js/internals/has.js");
var uid = __webpack_require__(/*! ../internals/uid */ "./node_modules/core-js/internals/uid.js");
var NATIVE_SYMBOL = __webpack_require__(/*! ../internals/native-symbol */ "./node_modules/core-js/internals/native-symbol.js");
var USE_SYMBOL_AS_UID = __webpack_require__(/*! ../internals/use-symbol-as-uid */ "./node_modules/core-js/internals/use-symbol-as-uid.js");

var WellKnownSymbolsStore = shared('wks');
var Symbol = global.Symbol;
var createWellKnownSymbol = USE_SYMBOL_AS_UID ? Symbol : Symbol && Symbol.withoutSetter || uid;

module.exports = function (name) {
  if (!has(WellKnownSymbolsStore, name) || !(NATIVE_SYMBOL || typeof WellKnownSymbolsStore[name] == 'string')) {
    if (NATIVE_SYMBOL && has(Symbol, name)) {
      WellKnownSymbolsStore[name] = Symbol[name];
    } else {
      WellKnownSymbolsStore[name] = createWellKnownSymbol('Symbol.' + name);
    }
  } return WellKnownSymbolsStore[name];
};


/***/ }),

/***/ "./node_modules/core-js/internals/whitespaces.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/whitespaces.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// a string of all valid unicode whitespaces
module.exports = '\u0009\u000A\u000B\u000C\u000D\u0020\u00A0\u1680\u2000\u2001\u2002' +
  '\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u3000\u2028\u2029\uFEFF';


/***/ }),

/***/ "./node_modules/core-js/modules/es.array.slice.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/modules/es.array.slice.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");
var isArray = __webpack_require__(/*! ../internals/is-array */ "./node_modules/core-js/internals/is-array.js");
var toAbsoluteIndex = __webpack_require__(/*! ../internals/to-absolute-index */ "./node_modules/core-js/internals/to-absolute-index.js");
var toLength = __webpack_require__(/*! ../internals/to-length */ "./node_modules/core-js/internals/to-length.js");
var toIndexedObject = __webpack_require__(/*! ../internals/to-indexed-object */ "./node_modules/core-js/internals/to-indexed-object.js");
var createProperty = __webpack_require__(/*! ../internals/create-property */ "./node_modules/core-js/internals/create-property.js");
var wellKnownSymbol = __webpack_require__(/*! ../internals/well-known-symbol */ "./node_modules/core-js/internals/well-known-symbol.js");
var arrayMethodHasSpeciesSupport = __webpack_require__(/*! ../internals/array-method-has-species-support */ "./node_modules/core-js/internals/array-method-has-species-support.js");

var HAS_SPECIES_SUPPORT = arrayMethodHasSpeciesSupport('slice');

var SPECIES = wellKnownSymbol('species');
var nativeSlice = [].slice;
var max = Math.max;

// `Array.prototype.slice` method
// https://tc39.es/ecma262/#sec-array.prototype.slice
// fallback for not array-like ES3 strings and DOM objects
$({ target: 'Array', proto: true, forced: !HAS_SPECIES_SUPPORT }, {
  slice: function slice(start, end) {
    var O = toIndexedObject(this);
    var length = toLength(O.length);
    var k = toAbsoluteIndex(start, length);
    var fin = toAbsoluteIndex(end === undefined ? length : end, length);
    // inline `ArraySpeciesCreate` for usage native `Array#slice` where it's possible
    var Constructor, result, n;
    if (isArray(O)) {
      Constructor = O.constructor;
      // cross-realm fallback
      if (typeof Constructor == 'function' && (Constructor === Array || isArray(Constructor.prototype))) {
        Constructor = undefined;
      } else if (isObject(Constructor)) {
        Constructor = Constructor[SPECIES];
        if (Constructor === null) Constructor = undefined;
      }
      if (Constructor === Array || Constructor === undefined) {
        return nativeSlice.call(O, k, fin);
      }
    }
    result = new (Constructor === undefined ? Array : Constructor)(max(fin - k, 0));
    for (n = 0; k < fin; k++, n++) if (k in O) createProperty(result, n, O[k]);
    result.length = n;
    return result;
  }
});


/***/ }),

/***/ "./node_modules/core-js/modules/es.number.to-fixed.js":
/*!************************************************************!*\
  !*** ./node_modules/core-js/modules/es.number.to-fixed.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var toInteger = __webpack_require__(/*! ../internals/to-integer */ "./node_modules/core-js/internals/to-integer.js");
var thisNumberValue = __webpack_require__(/*! ../internals/this-number-value */ "./node_modules/core-js/internals/this-number-value.js");
var repeat = __webpack_require__(/*! ../internals/string-repeat */ "./node_modules/core-js/internals/string-repeat.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");

var nativeToFixed = 1.0.toFixed;
var floor = Math.floor;

var pow = function (x, n, acc) {
  return n === 0 ? acc : n % 2 === 1 ? pow(x, n - 1, acc * x) : pow(x * x, n / 2, acc);
};

var log = function (x) {
  var n = 0;
  var x2 = x;
  while (x2 >= 4096) {
    n += 12;
    x2 /= 4096;
  }
  while (x2 >= 2) {
    n += 1;
    x2 /= 2;
  } return n;
};

var multiply = function (data, n, c) {
  var index = -1;
  var c2 = c;
  while (++index < 6) {
    c2 += n * data[index];
    data[index] = c2 % 1e7;
    c2 = floor(c2 / 1e7);
  }
};

var divide = function (data, n) {
  var index = 6;
  var c = 0;
  while (--index >= 0) {
    c += data[index];
    data[index] = floor(c / n);
    c = (c % n) * 1e7;
  }
};

var dataToString = function (data) {
  var index = 6;
  var s = '';
  while (--index >= 0) {
    if (s !== '' || index === 0 || data[index] !== 0) {
      var t = String(data[index]);
      s = s === '' ? t : s + repeat.call('0', 7 - t.length) + t;
    }
  } return s;
};

var FORCED = nativeToFixed && (
  0.00008.toFixed(3) !== '0.000' ||
  0.9.toFixed(0) !== '1' ||
  1.255.toFixed(2) !== '1.25' ||
  1000000000000000128.0.toFixed(0) !== '1000000000000000128'
) || !fails(function () {
  // V8 ~ Android 4.3-
  nativeToFixed.call({});
});

// `Number.prototype.toFixed` method
// https://tc39.es/ecma262/#sec-number.prototype.tofixed
$({ target: 'Number', proto: true, forced: FORCED }, {
  toFixed: function toFixed(fractionDigits) {
    var number = thisNumberValue(this);
    var fractDigits = toInteger(fractionDigits);
    var data = [0, 0, 0, 0, 0, 0];
    var sign = '';
    var result = '0';
    var e, z, j, k;

    if (fractDigits < 0 || fractDigits > 20) throw RangeError('Incorrect fraction digits');
    // eslint-disable-next-line no-self-compare -- NaN check
    if (number != number) return 'NaN';
    if (number <= -1e21 || number >= 1e21) return String(number);
    if (number < 0) {
      sign = '-';
      number = -number;
    }
    if (number > 1e-21) {
      e = log(number * pow(2, 69, 1)) - 69;
      z = e < 0 ? number * pow(2, -e, 1) : number / pow(2, e, 1);
      z *= 0x10000000000000;
      e = 52 - e;
      if (e > 0) {
        multiply(data, 0, z);
        j = fractDigits;
        while (j >= 7) {
          multiply(data, 1e7, 0);
          j -= 7;
        }
        multiply(data, pow(10, j, 1), 0);
        j = e - 1;
        while (j >= 23) {
          divide(data, 1 << 23);
          j -= 23;
        }
        divide(data, 1 << j);
        multiply(data, 1, 1);
        divide(data, 2);
        result = dataToString(data);
      } else {
        multiply(data, 0, z);
        multiply(data, 1 << -e, 0);
        result = dataToString(data) + repeat.call('0', fractDigits);
      }
    }
    if (fractDigits > 0) {
      k = result.length;
      result = sign + (k <= fractDigits
        ? '0.' + repeat.call('0', fractDigits - k) + result
        : result.slice(0, k - fractDigits) + '.' + result.slice(k - fractDigits));
    } else {
      result = sign + result;
    } return result;
  }
});


/***/ }),

/***/ "./node_modules/core-js/modules/es.object.keys.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/modules/es.object.keys.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var toObject = __webpack_require__(/*! ../internals/to-object */ "./node_modules/core-js/internals/to-object.js");
var nativeKeys = __webpack_require__(/*! ../internals/object-keys */ "./node_modules/core-js/internals/object-keys.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");

var FAILS_ON_PRIMITIVES = fails(function () { nativeKeys(1); });

// `Object.keys` method
// https://tc39.es/ecma262/#sec-object.keys
$({ target: 'Object', stat: true, forced: FAILS_ON_PRIMITIVES }, {
  keys: function keys(it) {
    return nativeKeys(toObject(it));
  }
});


/***/ }),

/***/ "./node_modules/core-js/modules/es.object.values.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/modules/es.object.values.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var $values = __webpack_require__(/*! ../internals/object-to-array */ "./node_modules/core-js/internals/object-to-array.js").values;

// `Object.values` method
// https://tc39.es/ecma262/#sec-object.values
$({ target: 'Object', stat: true }, {
  values: function values(O) {
    return $values(O);
  }
});


/***/ }),

/***/ "./node_modules/core-js/modules/es.parse-float.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/modules/es.parse-float.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var parseFloatImplementation = __webpack_require__(/*! ../internals/number-parse-float */ "./node_modules/core-js/internals/number-parse-float.js");

// `parseFloat` method
// https://tc39.es/ecma262/#sec-parsefloat-string
$({ global: true, forced: parseFloat != parseFloatImplementation }, {
  parseFloat: parseFloatImplementation
});


/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.constructor.js":
/*!***************************************************************!*\
  !*** ./node_modules/core-js/modules/es.regexp.constructor.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var isForced = __webpack_require__(/*! ../internals/is-forced */ "./node_modules/core-js/internals/is-forced.js");
var inheritIfRequired = __webpack_require__(/*! ../internals/inherit-if-required */ "./node_modules/core-js/internals/inherit-if-required.js");
var defineProperty = __webpack_require__(/*! ../internals/object-define-property */ "./node_modules/core-js/internals/object-define-property.js").f;
var getOwnPropertyNames = __webpack_require__(/*! ../internals/object-get-own-property-names */ "./node_modules/core-js/internals/object-get-own-property-names.js").f;
var isRegExp = __webpack_require__(/*! ../internals/is-regexp */ "./node_modules/core-js/internals/is-regexp.js");
var getFlags = __webpack_require__(/*! ../internals/regexp-flags */ "./node_modules/core-js/internals/regexp-flags.js");
var stickyHelpers = __webpack_require__(/*! ../internals/regexp-sticky-helpers */ "./node_modules/core-js/internals/regexp-sticky-helpers.js");
var redefine = __webpack_require__(/*! ../internals/redefine */ "./node_modules/core-js/internals/redefine.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var enforceInternalState = __webpack_require__(/*! ../internals/internal-state */ "./node_modules/core-js/internals/internal-state.js").enforce;
var setSpecies = __webpack_require__(/*! ../internals/set-species */ "./node_modules/core-js/internals/set-species.js");
var wellKnownSymbol = __webpack_require__(/*! ../internals/well-known-symbol */ "./node_modules/core-js/internals/well-known-symbol.js");

var MATCH = wellKnownSymbol('match');
var NativeRegExp = global.RegExp;
var RegExpPrototype = NativeRegExp.prototype;
var re1 = /a/g;
var re2 = /a/g;

// "new" should create a new object, old webkit bug
var CORRECT_NEW = new NativeRegExp(re1) !== re1;

var UNSUPPORTED_Y = stickyHelpers.UNSUPPORTED_Y;

var FORCED = DESCRIPTORS && isForced('RegExp', (!CORRECT_NEW || UNSUPPORTED_Y || fails(function () {
  re2[MATCH] = false;
  // RegExp constructor can alter flags and IsRegExp works correct with @@match
  return NativeRegExp(re1) != re1 || NativeRegExp(re2) == re2 || NativeRegExp(re1, 'i') != '/a/i';
})));

// `RegExp` constructor
// https://tc39.es/ecma262/#sec-regexp-constructor
if (FORCED) {
  var RegExpWrapper = function RegExp(pattern, flags) {
    var thisIsRegExp = this instanceof RegExpWrapper;
    var patternIsRegExp = isRegExp(pattern);
    var flagsAreUndefined = flags === undefined;
    var sticky;

    if (!thisIsRegExp && patternIsRegExp && pattern.constructor === RegExpWrapper && flagsAreUndefined) {
      return pattern;
    }

    if (CORRECT_NEW) {
      if (patternIsRegExp && !flagsAreUndefined) pattern = pattern.source;
    } else if (pattern instanceof RegExpWrapper) {
      if (flagsAreUndefined) flags = getFlags.call(pattern);
      pattern = pattern.source;
    }

    if (UNSUPPORTED_Y) {
      sticky = !!flags && flags.indexOf('y') > -1;
      if (sticky) flags = flags.replace(/y/g, '');
    }

    var result = inheritIfRequired(
      CORRECT_NEW ? new NativeRegExp(pattern, flags) : NativeRegExp(pattern, flags),
      thisIsRegExp ? this : RegExpPrototype,
      RegExpWrapper
    );

    if (UNSUPPORTED_Y && sticky) {
      var state = enforceInternalState(result);
      state.sticky = true;
    }

    return result;
  };
  var proxy = function (key) {
    key in RegExpWrapper || defineProperty(RegExpWrapper, key, {
      configurable: true,
      get: function () { return NativeRegExp[key]; },
      set: function (it) { NativeRegExp[key] = it; }
    });
  };
  var keys = getOwnPropertyNames(NativeRegExp);
  var index = 0;
  while (keys.length > index) proxy(keys[index++]);
  RegExpPrototype.constructor = RegExpWrapper;
  RegExpWrapper.prototype = RegExpPrototype;
  redefine(global, 'RegExp', RegExpWrapper);
}

// https://tc39.es/ecma262/#sec-get-regexp-@@species
setSpecies('RegExp');


/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.exec.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/modules/es.regexp.exec.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var exec = __webpack_require__(/*! ../internals/regexp-exec */ "./node_modules/core-js/internals/regexp-exec.js");

// `RegExp.prototype.exec` method
// https://tc39.es/ecma262/#sec-regexp.prototype.exec
$({ target: 'RegExp', proto: true, forced: /./.exec !== exec }, {
  exec: exec
});


/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.to-string.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/modules/es.regexp.to-string.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var redefine = __webpack_require__(/*! ../internals/redefine */ "./node_modules/core-js/internals/redefine.js");
var anObject = __webpack_require__(/*! ../internals/an-object */ "./node_modules/core-js/internals/an-object.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var flags = __webpack_require__(/*! ../internals/regexp-flags */ "./node_modules/core-js/internals/regexp-flags.js");

var TO_STRING = 'toString';
var RegExpPrototype = RegExp.prototype;
var nativeToString = RegExpPrototype[TO_STRING];

var NOT_GENERIC = fails(function () { return nativeToString.call({ source: 'a', flags: 'b' }) != '/a/b'; });
// FF44- RegExp#toString has a wrong name
var INCORRECT_NAME = nativeToString.name != TO_STRING;

// `RegExp.prototype.toString` method
// https://tc39.es/ecma262/#sec-regexp.prototype.tostring
if (NOT_GENERIC || INCORRECT_NAME) {
  redefine(RegExp.prototype, TO_STRING, function toString() {
    var R = anObject(this);
    var p = String(R.source);
    var rf = R.flags;
    var f = String(rf === undefined && R instanceof RegExp && !('flags' in RegExpPrototype) ? flags.call(R) : rf);
    return '/' + p + '/' + f;
  }, { unsafe: true });
}


/***/ }),

/***/ "./node_modules/core-js/modules/es.string.replace.js":
/*!***********************************************************!*\
  !*** ./node_modules/core-js/modules/es.string.replace.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var fixRegExpWellKnownSymbolLogic = __webpack_require__(/*! ../internals/fix-regexp-well-known-symbol-logic */ "./node_modules/core-js/internals/fix-regexp-well-known-symbol-logic.js");
var anObject = __webpack_require__(/*! ../internals/an-object */ "./node_modules/core-js/internals/an-object.js");
var toLength = __webpack_require__(/*! ../internals/to-length */ "./node_modules/core-js/internals/to-length.js");
var toInteger = __webpack_require__(/*! ../internals/to-integer */ "./node_modules/core-js/internals/to-integer.js");
var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");
var advanceStringIndex = __webpack_require__(/*! ../internals/advance-string-index */ "./node_modules/core-js/internals/advance-string-index.js");
var getSubstitution = __webpack_require__(/*! ../internals/get-substitution */ "./node_modules/core-js/internals/get-substitution.js");
var regExpExec = __webpack_require__(/*! ../internals/regexp-exec-abstract */ "./node_modules/core-js/internals/regexp-exec-abstract.js");

var max = Math.max;
var min = Math.min;

var maybeToString = function (it) {
  return it === undefined ? it : String(it);
};

// @@replace logic
fixRegExpWellKnownSymbolLogic('replace', 2, function (REPLACE, nativeReplace, maybeCallNative, reason) {
  var REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE = reason.REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE;
  var REPLACE_KEEPS_$0 = reason.REPLACE_KEEPS_$0;
  var UNSAFE_SUBSTITUTE = REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE ? '$' : '$0';

  return [
    // `String.prototype.replace` method
    // https://tc39.es/ecma262/#sec-string.prototype.replace
    function replace(searchValue, replaceValue) {
      var O = requireObjectCoercible(this);
      var replacer = searchValue == undefined ? undefined : searchValue[REPLACE];
      return replacer !== undefined
        ? replacer.call(searchValue, O, replaceValue)
        : nativeReplace.call(String(O), searchValue, replaceValue);
    },
    // `RegExp.prototype[@@replace]` method
    // https://tc39.es/ecma262/#sec-regexp.prototype-@@replace
    function (regexp, replaceValue) {
      if (
        (!REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE && REPLACE_KEEPS_$0) ||
        (typeof replaceValue === 'string' && replaceValue.indexOf(UNSAFE_SUBSTITUTE) === -1)
      ) {
        var res = maybeCallNative(nativeReplace, regexp, this, replaceValue);
        if (res.done) return res.value;
      }

      var rx = anObject(regexp);
      var S = String(this);

      var functionalReplace = typeof replaceValue === 'function';
      if (!functionalReplace) replaceValue = String(replaceValue);

      var global = rx.global;
      if (global) {
        var fullUnicode = rx.unicode;
        rx.lastIndex = 0;
      }
      var results = [];
      while (true) {
        var result = regExpExec(rx, S);
        if (result === null) break;

        results.push(result);
        if (!global) break;

        var matchStr = String(result[0]);
        if (matchStr === '') rx.lastIndex = advanceStringIndex(S, toLength(rx.lastIndex), fullUnicode);
      }

      var accumulatedResult = '';
      var nextSourcePosition = 0;
      for (var i = 0; i < results.length; i++) {
        result = results[i];

        var matched = String(result[0]);
        var position = max(min(toInteger(result.index), S.length), 0);
        var captures = [];
        // NOTE: This is equivalent to
        //   captures = result.slice(1).map(maybeToString)
        // but for some reason `nativeSlice.call(result, 1, result.length)` (called in
        // the slice polyfill when slicing native arrays) "doesn't work" in safari 9 and
        // causes a crash (https://pastebin.com/N21QzeQA) when trying to debug it.
        for (var j = 1; j < result.length; j++) captures.push(maybeToString(result[j]));
        var namedCaptures = result.groups;
        if (functionalReplace) {
          var replacerArgs = [matched].concat(captures, position, S);
          if (namedCaptures !== undefined) replacerArgs.push(namedCaptures);
          var replacement = String(replaceValue.apply(undefined, replacerArgs));
        } else {
          replacement = getSubstitution(matched, S, position, captures, namedCaptures, replaceValue);
        }
        if (position >= nextSourcePosition) {
          accumulatedResult += S.slice(nextSourcePosition, position) + replacement;
          nextSourcePosition = position + matched.length;
        }
      }
      return accumulatedResult + S.slice(nextSourcePosition);
    }
  ];
});


/***/ }),

/***/ "./node_modules/core-js/modules/es.string.trim.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/modules/es.string.trim.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var $trim = __webpack_require__(/*! ../internals/string-trim */ "./node_modules/core-js/internals/string-trim.js").trim;
var forcedStringTrimMethod = __webpack_require__(/*! ../internals/string-trim-forced */ "./node_modules/core-js/internals/string-trim-forced.js");

// `String.prototype.trim` method
// https://tc39.es/ecma262/#sec-string.prototype.trim
$({ target: 'String', proto: true, forced: forcedStringTrimMethod('trim') }, {
  trim: function trim() {
    return $trim(this);
  }
});


/***/ }),

/***/ "./node_modules/core-js/modules/web.dom-collections.for-each.js":
/*!**********************************************************************!*\
  !*** ./node_modules/core-js/modules/web.dom-collections.for-each.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var DOMIterables = __webpack_require__(/*! ../internals/dom-iterables */ "./node_modules/core-js/internals/dom-iterables.js");
var forEach = __webpack_require__(/*! ../internals/array-for-each */ "./node_modules/core-js/internals/array-for-each.js");
var createNonEnumerableProperty = __webpack_require__(/*! ../internals/create-non-enumerable-property */ "./node_modules/core-js/internals/create-non-enumerable-property.js");

for (var COLLECTION_NAME in DOMIterables) {
  var Collection = global[COLLECTION_NAME];
  var CollectionPrototype = Collection && Collection.prototype;
  // some Chrome versions have non-configurable methods on DOMTokenList
  if (CollectionPrototype && CollectionPrototype.forEach !== forEach) try {
    createNonEnumerableProperty(CollectionPrototype, 'forEach', forEach);
  } catch (error) {
    CollectionPrototype.forEach = forEach;
  }
}


/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ "./src/js/assets/amount.js":
/*!*********************************!*\
  !*** ./src/js/assets/amount.js ***!
  \*********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);


var amount = function amount() {
  var amountBlock = document.querySelectorAll('.dots.amount');
  console.log(amountBlock)

  if (amountBlock) {
    amountBlock.forEach(function (amount) {
      function addVal() {
        amount.children[1].value = +amount.children[1].value + 1;

        if (amount.children[1].value == 99) {
          amount.children[2].removeEventListener('click', addVal);
        } else {
          amount.children[0].addEventListener('click', decrVal);
          amount.children[2].addEventListener('click', addVal);
        }

        amount.children[0].addEventListener('click', decrVal);
      }
      amount.children[0].addEventListener('click', decrVal);

      amount.children[2].addEventListener('click', addVal);

      function decrVal() {
        console.log("less")
        if (amount.children[1].value < 3) {
          amount.children[0].removeEventListener('click', decrVal);
        } else {
          amount.children[2].addEventListener('click', addVal);
          amount.children[0].addEventListener('click', decrVal);
        }

        amount.children[1].value = +amount.children[1].value - 1;
      }
    });
  }
};

/* harmony default export */ __webpack_exports__["default"] = (amount);

/***/ }),

/***/ "./src/js/assets/appenChildSlider.js":
/*!*******************************************!*\
  !*** ./src/js/assets/appenChildSlider.js ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_slice_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.slice.js */ "./node_modules/core-js/modules/es.array.slice.js");
/* harmony import */ var core_js_modules_es_array_slice_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_slice_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.number.to-fixed.js */ "./node_modules/core-js/modules/es.number.to-fixed.js");
/* harmony import */ var core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_2__);




var appendChildSlider = function appendChildSlider(_ref) {
  var sliderSelector = _ref.sliderSelector,
      _ref$amount = _ref.amount,
      amount = _ref$amount === void 0 ? 1 : _ref$amount,
      btnLeftSelector = _ref.btnLeftSelector,
      btnRightSelector = _ref.btnRightSelector,
      itemSelector = _ref.itemSelector,
      transitionTime = _ref.transitionTime,
      _ref$dots = _ref.dots,
      dots = _ref$dots === void 0 ? false : _ref$dots,
      _ref$autoScroll = _ref.autoScroll,
      autoScroll = _ref$autoScroll === void 0 ? false : _ref$autoScroll,
      _ref$displayedSlides = _ref.displayedSlides,
      displayedSlides = _ref$displayedSlides === void 0 ? 1 : _ref$displayedSlides,
      _ref$mobileAmount = _ref.mobileAmount,
      mobileAmount = _ref$mobileAmount === void 0 ? 1 : _ref$mobileAmount;
  var slider = document.querySelector(sliderSelector);

  if (slider) {
    var initSlider = function initSlider(amount, items) {
      for (var i = 0; i < amount; i++) {
        slider.children[0].insertAdjacentElement('afterbegin', slider.children[0].children[slider.children[0].children.length - 1]);
        slider.children[0].style.transform = "translateX(-".concat((items[0].clientWidth + (+getComputedStyle(items[0]).marginRight.slice(0, -2) + +getComputedStyle(items[0]).marginLeft.slice(0, -2))) * amount, "px)");
      } 
      
      
      
      // if(!((items.length % 2) === 0) && (displayedSlides === 1)) {
      //     // slider.children[0].style.transform = `translateX(${items[0].clientWidth/2 + (+getComputedStyle(items[0]).marginRight.slice(0, -2) + +getComputedStyle(items[0]).marginLeft.slice(0, -2))/2}px)`
      // } else if (!(displayedSlides % 2 === 0) ) {
      //     if(((items.length % 2) === 0)) {
      //         slider.children[0].style.transform = `translateX(${items[0].clientWidth/2}px)`
      //     }
      // }


  
      if (dotsBtns) {
        var addListener = function addListener() {
          var dots = slider.querySelectorAll('.dot');
          dots.forEach(function (dot) {
            dot.addEventListener('click', function (e) {
              var activeDot = document.querySelector('.dot_active');
              var slideFrom = activeDot.getAttribute('data-slide-to');
              var slideTo = e.target.getAttribute('data-slide-to'); // console.log(slideTo - slideFrom)

              dots.forEach(function (dot) {
                return dot.style.pointerEvents = 'none';
              });

              function addPointerEvents() {
                dots.forEach(function (dot) {
                  return dot.style.pointerEvents = 'unset';
                });
              }

              setTimeout(addPointerEvents, transitionTime * 1000);

              if (activeDot.getAttribute('data-slide-to') == 1 && e.target.getAttribute('data-slide-to') == items.length) {
                scrollLeft(1);
                dots.forEach(function (dot) {
                  return dot.classList.remove('dot_active');
                });
                e.target.classList.add('dot_active');
              } else if (activeDot.getAttribute('data-slide-to') == items.length && e.target.getAttribute('data-slide-to') == 1) {
                scrollRight(1);
                dots.forEach(function (dot) {
                  return dot.classList.remove('dot_active');
                });
                e.target.classList.add('dot_active');
              } else {
                if (slideTo - slideFrom > 0) {
                  if (Math.abs(slideTo - slideFrom) > Math.floor(items.length / 2)) {
                    scrollLeft(+items.length - Math.abs(slideTo - slideFrom));
                  } else {
                    scrollRight(slideTo - slideFrom);
                  }

                  dots.forEach(function (dot) {
                    return dot.classList.remove('dot_active');
                  });
                  e.target.classList.add('dot_active');
                } else {
                  if (Math.abs(slideTo - slideFrom) >= (items.length / 2).toFixed(0)) {
                    scrollRight(+items.length - Math.abs(slideTo - slideFrom));
                  } else {
                    scrollLeft(Math.abs(slideTo - slideFrom));
                  }

                  dots.forEach(function (dot) {
                    return dot.classList.remove('dot_active');
                  });
                  e.target.classList.add('dot_active');
                }
              }
            });
          });
        };

        for (var _i = 0; _i < items.length; _i++) {
          items[_i].setAttribute('item-slide', _i + 1);
        }

        for (var _i2 = 0; _i2 < slider.children[0].children.length; _i2++) {
          var dot = document.createElement('div');
          dot.setAttribute('class', 'dot');
          dot.setAttribute('data-slide-to', _i2 + 1);
          dotsBtns.appendChild(dot);
        }

        var _dots = slider.querySelectorAll('.dot'); // console.log(dots.length/2)


        _dots[0].classList.add('dot_active');

        addListener(); // window.addEventListener('resize', () => {
        //     addListener()
        // })   
      }

      var btnLeft = slider.parentElement.querySelector(btnLeftSelector),
          sliderItems = (slider.clientWidth / items[0].clientWidth).toFixed(0),
          btnRight = slider.parentElement.querySelector(btnRightSelector);

      if (amount > sliderItems) {
        amount = sliderItems;
      }

      var paused = false;

      function activateAnimation() {
        paused = setInterval(function () {
          scrollRight(amount);
        }, autoScroll);
      }

      if (autoScroll) {
        activateAnimation();
        slider.addEventListener('mouseenter', function () {
          clearInterval(paused);
        });
        slider.addEventListener('mouseleave', function () {
          clearInterval(paused);
          activateAnimation();
        });
      }

      function scrollRight(amount) {
        items.forEach(function (item) {
          item.style.transition = '0s';
          item.classList.add('scrolling');
          btnRight.style.pointerEvents = 'all';
        });
        slider.style.pointerEvents = 'none';
        items.forEach(function (item) {
          item.style.transition = "".concat(transitionTime, "s all");
          item.style.transform = "translateX(-".concat((item.clientWidth + +getComputedStyle(item).marginRight.slice(0, -2) + +getComputedStyle(item).marginLeft.slice(0, -2)) * amount, "px)");
          btnRight.style.pointerEvents = 'none';
        });

        for (var _i3 = 0; _i3 < amount; _i3++) {
          var toLeft = function toLeft() {
            items.forEach(function (item) {
              item.classList.remove('scrolling');
              item.style.transition = '0s';
              item.style.transform = 'none';
              btnRight.style.pointerEvents = 'all';
            });
            slider.style.pointerEvents = 'all';
            slider.children[0].appendChild(slider.children[0].children[0]);
          };

          setTimeout(toLeft, transitionTime * 1000);
        }

        if (dotsBtns) {
          var _dots2 = document.querySelectorAll('.dot');

          var activeDot = document.querySelector('.dot_active');

          _dots2.forEach(function (dot) {
            dot.classList.remove('dot_active');

            if (activeDot.getAttribute('data-slide-to') == items.length) {
              _dots2[0].classList.add('dot_active');
            } else {
              if (dot.getAttribute('data-slide-to') == +activeDot.getAttribute('data-slide-to') + 1) {
                dot.classList.add('dot_active');
              }
            }
          });
        }
      }

      function scrollLeft(amount) {
        items.forEach(function (item) {
          // item.style.transform = 'none';
          item.style.transition = '0s all';
          item.classList.add('scrolling');
          btnLeft.style.pointerEvents = 'all';
        });
        items.forEach(function (item) {
          item.style.transition = "".concat(transitionTime, "s all");
          item.style.transform = "translateX(".concat((item.clientWidth + +getComputedStyle(item).marginRight.slice(0, -2) + +getComputedStyle(item).marginLeft.slice(0, -2)) * amount, "px)");
          btnLeft.style.pointerEvents = 'none';
        });

        for (var _i4 = 0; _i4 < amount; _i4++) {
          var toRight = function toRight() {
            items.forEach(function (item) {
              item.style.transition = '0s all';
              item.classList.remove('scrolling');
              item.style.transform = 'none';
              btnLeft.style.pointerEvents = 'all';
            });
            slider.children[0].insertAdjacentElement('afterbegin', slider.children[0].children[slider.children[0].children.length - 1]);
          };

          setTimeout(toRight, transitionTime * 1000);
        }

        if (dotsBtns) {
          var _dots3 = document.querySelectorAll('.dot');

          var activeDot = document.querySelector('.dot_active');

          _dots3.forEach(function (dot) {
            dot.classList.remove('dot_active');

            if (activeDot.getAttribute('data-slide-to') == 1) {
              _dots3[items.length - 1].classList.add('dot_active');
            } else {
              if (dot.getAttribute('data-slide-to') == activeDot.getAttribute('data-slide-to') - 1) {
                dot.classList.add('dot_active');
              }
            }
          });
        }
      }

      if (btnLeft) {
        btnRight.addEventListener('click', function () {
          scrollRight(amount);
        });
        btnLeft.addEventListener('click', function () {
          scrollLeft(amount);
        });
      }

      function currentSlide() {
        items.forEach(function (item) {
          if (!item.classList.contains('scrolling')) {
            item.style.transform = "translateX(0px)";
            item.style.transition = "".concat(transitionTime, "s all");
          }
        });
      }

      var viewport = slider.children[0].clientWidth,
          viewSlide = 0,
          posx = 0;

      function mouseDown(e) {
        if (autoScroll) {
          clearInterval(paused);
        }

        if (e.identifier === 0) {
          items.forEach(function (item) {
            item.style.transition = '0s all';
          });
          posx = e.clientX;
          return posx;
        } else {
          e.preventDefault();
          posx = e.clientX;
          items.forEach(function (item) {
            item.style.transition = '0s all';
          });
          return posx;
        }
      }

      function mouseUp(e) {
        if (e.clientX - posx < -viewport * 0.3 * amount) {
          slider.style.transition = "".concat(transitionTime, "s all");
          scrollRight(amount);
        } else {
          slider.style.transition = "".concat(transitionTime, "s all");
          currentSlide();
        }

        posx = 0;

        if (autoScroll) {
          clearInterval(paused);
          activateAnimation();
        }
      }

      function moving(e) {
        if (autoScroll) {
          clearInterval(paused);
        }

        function leaving() {
          items.forEach(function (item) {
            item.style.transition = "".concat(transitionTime, "s all");
          });
          currentSlide();
          posx = 0;
        }

        slider.addEventListener('mouseleave', function () {
          leaving();
        });

        if (posx > 0) {
          items.forEach(function (item) {
            item.style.transition = "0s all";
          });
          items.forEach(function (item) {
            item.style.transform = "translateX(".concat(-viewSlide * viewport - posx + e.clientX, "px");
          });

          if (-posx + e.clientX < -viewport * 0.3) {
            items.forEach(function (item) {
              item.style.transition = "".concat(transitionTime, "s all");
            });
            scrollRight(amount);

            if (autoScroll) {
              clearInterval(paused);
              activateAnimation();
            }

            posx = 0;
          } else if (e.clientX - posx > viewport * 0.3) {
            items.forEach(function (item) {
              item.style.transition = "".concat(transitionTime, "s all");
            });
            scrollLeft(amount);

            if (autoScroll) {
              clearInterval(paused);
              activateAnimation();
            }

            posx = 0;
          }
        } else if (posx == 0) {
          slider.removeEventListener('mousemove', moving);
          slider.removeEventListener('touchmove', moving);
        }
      }
      function touchStart(e) {
        posx = e.touches[0].clientX;
        items.forEach(function (item) {
          item.style.transition = "".concat(transitionTime, "s all");
        });
        return posx;
      }

      

      if(!(slider.children[0].children.length *slider.children[0].children[0].clientWidth < slider.children[0].clientWidth)) {

        slider.addEventListener('touchstart', function (e) {
          touchStart(e);
        }, {
          passive: true
        });
        slider.addEventListener('touchmove', function (e) {
          moving(e.touches[0]);
        }, {
          passive: true
        });
        slider.addEventListener('touchend', function (e) {
          mouseUp(e);
        });
        slider.addEventListener("mousedown", function (e) {
          mouseDown(e);
        });
        slider.addEventListener('mouseup', function (e) {
          mouseUp(e);
        });
        slider.addEventListener('mousemove', function (e) {
          moving(e);
        });
      } else {
        slider.classList.add('less-slides')
        slider.children[0].style.transform = 'none';
        slider.nextElementSibling.style.display = 'none';
      }
    };
   
    var items = slider.querySelectorAll(itemSelector);
    var dotsBtns = document.querySelector(dots);

    if (items.length <= 2) {
      // var newItem = items[0].cloneNode(true);
      // slider.children[0].appendChild(newItem);
      var items = slider.querySelectorAll(itemSelector);
    } else {
      var items = slider.querySelectorAll(itemSelector);
    }

    if (document.documentElement.clientWidth < 768) {
      if (mobileAmount != amount && mobileAmount) {
        initSlider(mobileAmount);
      } else {
        initSlider(amount, items);
      }
    } else {
      initSlider(amount, items);
    }
  }
};

/* harmony default export */ __webpack_exports__["default"] = (appendChildSlider);

/***/ }),

/***/ "./src/js/assets/backBtn.js":
/*!**********************************!*\
  !*** ./src/js/assets/backBtn.js ***!
  \**********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var backBtn = function backBtn() {
  var back = document.querySelector('.breadcrumbs-back');

  if (sessionStorage.getItem("thisSite")) {
    if (back) {
      back.addEventListener('click', function (e) {
        e.preventDefault();
        window.history.back();
      });
    }
  } else {
    var fromThisSite = true;
    sessionStorage.setItem("thisSite", fromThisSite);

    if (back) {
      back.addEventListener('click', function (e) {
        window.location = 'index.html';
      });
    }
  }
};

/* harmony default export */ __webpack_exports__["default"] = (backBtn);

/***/ }),

/***/ "./src/js/assets/cabinetScript.js":
/*!****************************************!*\
  !*** ./src/js/assets/cabinetScript.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);


var cabinetScript = function cabinetScript() {
  var personalBtn = document.querySelectorAll('.account__item'),
      historyBlock = document.querySelector('.account-info--order'),
      personalBlock = document.querySelector('.account-info--personal'),
      subscriptionBlock = document.querySelector('.account-info--subscription');

  if (personalBtn[0] ) {
    personalBtn.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();

        if (btn.classList.contains('account__item_active')) {
          btn.classList.remove('account__item_active');
          historyBlock.style.display = 'none';
          personalBlock.style.display = 'none';
          subscriptionBlock.style.display = "none"
        } else {
          personalBtn.forEach(function (btn) {
            return btn.classList.remove('account__item_active');
          });
          btn.classList.add('account__item_active');

          if (btn.classList.contains('account-page')) {
            historyBlock.style.display = 'none';
            personalBlock.style.display = 'block';
            subscriptionBlock.style.display = "none"

          } else if (btn.classList.contains("account__history")) {
            historyBlock.style.display = 'block';
            personalBlock.style.display = 'none';
            subscriptionBlock.style.display = "none"

          } else {
            historyBlock.style.display = 'none';
            personalBlock.style.display = 'none';
            subscriptionBlock.style.display = "block"
          }
        }
      });
    });
  }
};

/* harmony default export */ __webpack_exports__["default"] = (cabinetScript);

/***/ }),

/***/ "./src/js/assets/calc.js":
/*!*******************************!*\
  !*** ./src/js/assets/calc.js ***!
  \*******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_object_values_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.object.values.js */ "./node_modules/core-js/modules/es.object.values.js");
/* harmony import */ var core_js_modules_es_object_values_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_values_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_object_keys_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.object.keys.js */ "./node_modules/core-js/modules/es.object.keys.js");
/* harmony import */ var core_js_modules_es_object_keys_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_keys_js__WEBPACK_IMPORTED_MODULE_4__);






        var calc = function calc(sizes) {
          console.log(sizes)
          var calcForm = document.querySelector('.guide__form');

          if (calcForm) {
            var chest = calcForm.querySelector('.chest'),
                underChest = calcForm.querySelector('.under-chest'),
                hip = calcForm.querySelector('.hip'),
                insertPlace = document.querySelector('.guide__results'),
                input = calcForm.querySelectorAll('input'),
                error = calcForm.querySelector('.guide__error');
            input.forEach(function (i) {
              i.addEventListener('focus', function () {
                i.classList.remove('wrong');
              });
              i.addEventListener('input', function () {
                i.value = i.value.replace(/^([^0-9]*)$/g, '');
              });
            });
            calcForm.addEventListener('submit', function (e) {
              console.log(VARS.language_code)
              var phrases = {
                "ru": ['Размер лифа LoveLace — ', 'Размер трусиков'],
                "ua": ['Розмір ліфа LoveLace — ', 'Розмір трусиків'],
                "en": ['Bodice size LoveLace — ', 'Panties size']
              }
              e.preventDefault();
              error.classList.remove('guide__error_visible'); // console.log(insertPlace.children[0])


              var sizesC = [];
              // console.log(chest.value, underChest.value);

              for(var newObj in sizes.chestNew) {
                var opgSize,
                    ogSize;
                // console.log(sizes.chestNew[obj]["OPG"]);
                sizes.chestNew[newObj]["OPG"].forEach(item => {
                  if(item == underChest.value) {
                    console.log(item);
                    opgSize = newObj
                  }
                  if(sizes.chestNew[newObj]["OPG"].length === 1) {
                    opgSize = newObj
                  }
                })
                sizes.chestNew[newObj]["OG"].forEach(item => {
                  if(item == chest.value) {
                    ogSize = newObj
                  }
                  if(sizes.chestNew[newObj]["OPG"].length === 1) {
                    opgSize = newObj
                  }
                })
                if(opgSize && ogSize && (opgSize === ogSize)) {
                  console.log(opgSize);
                  if(opgSize != sizesC[0]) {
                    sizesC.push(opgSize)
                  }
                }
              }
              console.log(sizesC);
              if(sizesC.length === 0) {
                chest.classList.add("wrong");
                insertPlace.children[0].textContent = "";
                underChest.classList.add("wrong")
                error.classList.add('guide__error_visible');
                if(insertPlace.children[1].textContent === "") {
                  insertPlace.style.padding = '0';
                  insertPlace.children[1].style.marginTop = '0';
                }
              } else {
                insertPlace.style.padding = '16px 21px 24px 16px';
                insertPlace.children[1].style.marginTop = '16px';
                chest.classList.remove("wrong");
                underChest.classList.remove("wrong");
                var phrase = '';
                if(VARS.language_code === "ru-ru") {
                  phrase = phrases.ru[0]
                } else if (VARS.language_code === "uk-ua"){
                  phrase = phrases.ua[0]
                } else if (VARS.language_code === "en-gb") {
                  phrase = phrases.en[0]
                }
                if(sizesC.length === 1) {
                  insertPlace.children[0].textContent = phrase + sizesC.join();
                } else if(sizesC.length === 2) {
                  insertPlace.children[0].innerHTML = phrase + sizesC[0] + " либо " + sizesC[1] + ". Выбирайте " + sizesC[1] + ", если нужна чашка побольше. Либо можете связаться с нашим менеджером через <a href='https://t.me/lovelace2021_bot' target='_blank'>телеграм-бот</a>, <a href='https://www.instagram.com/lovelace.by/' target='_blank'>инстаграм</a>, чат на сайте, чтобы вам помогли определить размер. ";
                } else if(sizesC.length === 3) {
                  insertPlace.children[0].innerHTML = phrase + sizesC[0] +", " + sizesC[1] + " либо " + sizesC[2] + ". Выбирайте " + sizesC[2] + ", если нужна чашка побольше. Размер с плюсом является промежуточным между вышеуказанными размерами. Либо можете связаться с нашим менеджером <a href='https://t.me/lovelace2021_bot' target='_blank'>телеграм-бот</a>, <a href='https://www.instagram.com/lovelace.by/' target='_blank'>инстаграм</a>, чат на сайте, чтобы вам помогли определить размер. ";
                }
              }




              for (var _key in sizes.hip) {
                if (Math.round(+hip.value) >= sizes.hip[_key][0] && Math.round(+hip.value) <= sizes.hip[_key][1]) {
                  insertPlace.style.padding = '16px 21px 24px 16px';
                  insertPlace.children[1].style.marginTop = '16px';
                  var phrase = '';
                  if(VARS.language_code === "ru-ru") {
                    phrase = phrases.ru[1]
                  } else if (VARS.language_code === "uk-ua"){
                    phrase = phrases.ua[1]
                  } else if (VARS.language_code === "en-gb") {
                    phrase = phrases.en[1]
                  }
                  insertPlace.children[1].textContent = phrase + " \u2014 ".concat(_key);
                }
              }

              if (Math.round(+hip.value) < Object.values(sizes.hip)[0][0] || Math.round(+hip.value) > Object.values(sizes.hip)[Object.keys(sizes.hip).length - 1][1]) {
                hip.classList.add('wrong');
                insertPlace.children[1].textContent = "";
                if(insertPlace.children[0].textContent === "") {
                  insertPlace.style.padding = '0';
                  insertPlace.children[1].style.marginTop = '0';
                }
                error.classList.add('guide__error_visible');
              }
            });
          }
        };
/* harmony default export */ __webpack_exports__["default"] = (calc);

/***/ }),

/***/ "./src/js/assets/certificate.js":
/*!**************************************!*\
  !*** ./src/js/assets/certificate.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var certificate = function certificate() {
  var pBtn = document.querySelector('.radio__p'),
      eBtn = document.querySelector('.radio__e'),
      pText = document.querySelector('.certificate__p'),
      eText = document.querySelector('.certificate__e');

  if (eBtn) {
    eBtn.addEventListener('click', function () {
      if (eBtn.children[0].children[0].checked) {
        pText.style.display = 'none';
        eText.style.display = 'block';
      }
    });
    pBtn.addEventListener('click', function () {
      if (pBtn.children[0].children[0].checked) {
        eText.style.display = 'none';
        pText.style.display = 'block';
      }
    });
  }
};

/* harmony default export */ __webpack_exports__["default"] = (certificate);

/***/ }),

/***/ "./src/js/assets/dropdown.js":
/*!***********************************!*\
  !*** ./src/js/assets/dropdown.js ***!
  \***********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);


var dropdown = function dropdown() {
  var dropdown = document.querySelectorAll('.dropdown__btn');

  if (dropdown[0]) {
    var dropdown = document.querySelectorAll('.dropdown__btn');
    
    document.addEventListener('click', function (e) {
      if(e.target.classList.contains('dropdown__btn')) {
        if(e.target.parentElement.classList.contains('rotate')) {
          e.target.nextElementSibling.classList.remove('show');
          e.target.parentElement.classList.remove('rotate');
        } else {
          e.target.nextElementSibling.classList.remove('show');
          e.target.parentElement.classList.remove('rotate');
          e.target.nextElementSibling.classList.add('show');
          e.target.parentElement.classList.add('rotate');
        }
      }

      if (!e.target.classList.contains('dropdown__btn') && !e.target.classList.contains('dropdown__menu') && !e.target.parentElement.classList.contains('dropdown__btn') && e.target.parentElement.parentElement  && !e.target.parentElement.parentElement.classList.contains('dropdown__btn')) {
        var dropdown = document.querySelectorAll('.dropdown__btn');
        dropdown.forEach(function (btn) {
          if (btn.nextElementSibling && btn.nextElementSibling.classList.contains('show')) {
            btn.nextElementSibling.classList.remove('show');
            btn.parentElement.classList.remove('rotate');
          }
        });
      }
    });
    
  }
};

/* harmony default export */ __webpack_exports__["default"] = (dropdown);

/***/ }),

/***/ "./src/js/assets/faq.js":
/*!******************************!*\
  !*** ./src/js/assets/faq.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);


var faq = function faq() {
  var faqBtn = document.querySelectorAll('.faq__title');

  if (faqBtn[0]) {
        var product = document.querySelector('.product-imgs');

    document.addEventListener('click', function(e) {
      // console.log(e.target)
      if(e.target.classList.contains('faq__title')) {
        if(e.target.parentElement.classList.contains('faq-item_active')) {
          e.target.parentElement.classList.remove('faq-item_active'); 
        } else {
          if (!e.target.parentElement.classList.contains('faq-filter') && !product) {
            var items = document.querySelectorAll('.faq-item');
            items.forEach(function (i) {
              return i.classList.remove('faq-item_active');
            });
          }

          e.target.parentElement.classList.add('faq-item_active');
        }
      }
    })
  
  }
};

/* harmony default export */ __webpack_exports__["default"] = (faq);

/***/ }),

/***/ "./src/js/assets/filtersOpen.js":
/*!**************************************!*\
  !*** ./src/js/assets/filtersOpen.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var filtersOpen = function filtersOpen() {
  var filtersOpenBtn = document.querySelector('.catalog-open-filters');
  if (filtersOpenBtn) {
    document.addEventListener('click', function (e) {
      if(e.target.classList.contains('catalog-open-filters') || (e.target.parentElement && e.target.parentElement.classList.contains('catalog-open-filters')) || (e.target.parentElement.parentElement && e.target.parentElement.parentElement.classList.contains('catalog-open-filters'))) {
        var filtersMenu = document.querySelector('.catalog-filters');
        console.log(filtersMenu)
        if (filtersMenu.classList.contains('active')) {
          filtersMenu.style.display = 'none';
          filtersMenu.classList.remove('active');
        } else {
          filtersMenu.classList.add('active');
          filtersMenu.style.display = 'block';
        }
      }
    })
  }
};

/* harmony default export */ __webpack_exports__["default"] = (filtersOpen);

/***/ }),

/***/ "./src/js/assets/fixedScroll.js":
/*!**************************************!*\
  !*** ./src/js/assets/fixedScroll.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.number.to-fixed.js */ "./node_modules/core-js/modules/es.number.to-fixed.js");
/* harmony import */ var core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_0__);


var fixedScroll = function fixedScroll(scrolledItem, top, realTop) {
  var fixedBlock = document.querySelector(scrolledItem);
  // console.log(fixedBlock)
  if (fixedBlock) {
    fixedBlock.style.position = 'absolute';
    document.addEventListener('scroll', function () {
      var rect;

      if (scrolledItem == '.product .product-imgs') {
        var rect = fixedBlock.parentElement.nextElementSibling.getBoundingClientRect();
      } else {
        var rect = fixedBlock.nextElementSibling.getBoundingClientRect();
      }

      var rectBlock = fixedBlock.getBoundingClientRect();

      if (+(document.documentElement.clientHeight - rect.bottom).toFixed(0) >= +(document.documentElement.clientHeight - rectBlock.bottom).toFixed(0)) {
        fixedBlock.style.position = 'absolute';
        fixedBlock.style.bottom = '0';
        fixedBlock.style.top = 'unset';
      } else {
        fixedBlock.style.position = 'fixed';
        fixedBlock.style.bottom = 'unset';
        fixedBlock.style.top = "".concat(top, "px");
      }

      if (rect.bottom - fixedBlock.clientHeight - top > 0) {
        fixedBlock.style.position = 'fixed';
        fixedBlock.style.bottom = 'unset';
        fixedBlock.style.top = "".concat(top, "px");
      }

      if (realTop) {
        if (window.pageYOffset + top + 40 < realTop) {
          fixedBlock.style.position = 'absolute';
          fixedBlock.style.top = 0 + 'px';
        }
      }
    });
  }
};

/* harmony default export */ __webpack_exports__["default"] = (fixedScroll);

/***/ }),

/***/ "./src/js/assets/mobileMenu.js":
/*!*************************************!*\
  !*** ./src/js/assets/mobileMenu.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);


var mobileMenu = function mobileMenu() {
  var hamburger = document.querySelector('.hamburger');
  
  if (hamburger) {
    var _mobileMenu = document.querySelector('.header-mobile');

    hamburger.addEventListener('click', function (e) {
      e.preventDefault();

      if (_mobileMenu.classList.contains('header-mobile__active')) {
        document.body.style.overflow = 'visible';
      } else {
        document.body.style.overflow = 'hidden';
      }

      hamburger.classList.toggle('hamburger_active');

      _mobileMenu.classList.toggle('header-mobile__active');
    });
    var chockerMenu = document.querySelector('.add-chocker');
      var chockerBtn = document.querySelector('.choose-chocker');
      var overflow = document.querySelector('.overflow')

      if(chockerBtn) {
        var imgsSlider = document.querySelector('.add-chocker .product-imgs');
        var initPos = imgsSlider.parentElement;
        var targetPos = document.querySelector('.product-target')
        if(document.documentElement.clientWidth < 768) {
          targetPos.insertAdjacentElement('afterend', imgsSlider);
        } 
        window.addEventListener('resize', function() {
          if(document.documentElement.clientWidth < 768) {
            targetPos.insertAdjacentElement('afterend', imgsSlider);
          } else {
            initPos.appendChild(imgsSlider);
          }
        })
        chockerBtn.addEventListener('click', function() {
          overflow.classList.add('overflow_active');
          document.body.style.overflow = 'hidden';
        })
        var chockerClose = chockerMenu.querySelector('.add-chocker-close');
        chockerClose.addEventListener('click', function() {
          closePopup();
        })
      }
      function closePopup() {
        overflow.classList.remove('overflow_active');
        document.body.style.overflow = 'visible';

      }
    document.addEventListener('click', function (e) {
      function isDescendant(parent, child) {
        var node = child.parentNode;

        while (node != null) {
          if (node == parent) {
            return false;
          }

          node = node.parentNode;
        }

        return true;
      }
      
      if (isDescendant(_mobileMenu, e.target) && !e.target.classList.contains('choose-chocker') && isDescendant(chockerMenu, e.target) && !e.target.classList.contains('hamburger') && !e.target.classList.contains('header-mobile') && !e.target.parentElement.classList.contains('hamburger')) {
        hamburger.classList.remove('hamburger_active');

        _mobileMenu.classList.remove('header-mobile__active');
        if(chockerBtn) {
          closePopup();
        }
        document.body.style.overflow = 'visible';
      }
    });

    var itemsHasChild = _mobileMenu.querySelectorAll('.has-child');

    itemsHasChild.forEach(function (item) {
      item.addEventListener('click', function () {
        item.classList.toggle('has-child_active');
      });
    });
  }
};

/* harmony default export */ __webpack_exports__["default"] = (mobileMenu);

/***/ }),

/***/ "./src/js/assets/range.js":
/*!********************************!*\
  !*** ./src/js/assets/range.js ***!
  \********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_parse_float_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.parse-float.js */ "./node_modules/core-js/modules/es.parse-float.js");
/* harmony import */ var core_js_modules_es_parse_float_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_parse_float_js__WEBPACK_IMPORTED_MODULE_2__);




var range = function range() {
  // var displayElement = document.querySelector(".rangeValues"),
  //     ranges = document.querySelectorAll('[type="range"]');
  //
  // if (displayElement) {
  //   var correctNum = function correctNum(item, i) {
  //     item.addEventListener('input', function () {
  //       item.value = item.value.replace(/[^0-9]+/g, "");
  //
  //       if (item.value > 8600) {
  //         item.value = 8600;
  //       } else if (item.value < 0) {
  //         item.value = 0;
  //       }
  //
  //       ranges[i].value = item.value;
  //     });
  //   };
  //
  //   var getVals = function getVals() {
  //     // Get slider values
  //     var parent = this.parentNode;
  //     var slides = parent.getElementsByTagName("input");
  //     var slide1 = parseFloat(slides[0].value);
  //     var slide2 = parseFloat(slides[1].value); // Neither slider will clip the other, so make sure we determine which is larger
  //
  //     if (slide1 > slide2) {
  //       var tmp = slide2;
  //       slide2 = slide1;
  //       slide1 = tmp;
  //     }
  //
  //     displayElement.children[0].value = slide1;
  //     displayElement.children[1].value = slide2;
  //   };
  //
  //   correctNum(displayElement.children[0], 0);
  //   correctNum(displayElement.children[1], 1);
  //
  //   window.onload = function () {
  //     // Initialize Sliders
  //     var sliderSections = document.getElementsByClassName("range-slider");
  //
  //     for (var x = 0; x < sliderSections.length; x++) {
  //       var sliders = sliderSections[x].getElementsByTagName("input");
  //
  //       for (var y = 0; y < sliders.length; y++) {
  //         if (sliders[y].type === "range") {
  //           sliders[y].oninput = getVals; // Manually trigger event first time to display values
  //
  //           sliders[y].oninput();
  //         }
  //       }
  //     }
  //   };
  // }
};

/* harmony default export */ __webpack_exports__["default"] = (range);

/***/ }),

/***/ "./src/js/assets/seoMore.js":
/*!**********************************!*\
  !*** ./src/js/assets/seoMore.js ***!
  \**********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var seoMore = function seoMore() {
  var seoMoreBtn = document.querySelector('.seo__more');

  if (seoMoreBtn) {
    seoMoreBtn.addEventListener('click', function (e) {
      e.preventDefault();

      if (seoMoreBtn.classList.contains('active')) {
        seoMoreBtn.previousElementSibling.style.maxHeight = '24px';
        seoMoreBtn.innerText = 'Подробнее ↓';
        seoMoreBtn.classList.remove('active');
      } else {
        seoMoreBtn.previousElementSibling.style.maxHeight = '2000px';
        seoMoreBtn.innerText = 'Меньше ↑';
        seoMoreBtn.classList.add('active');
      }
    });
  }
};

/* harmony default export */ __webpack_exports__["default"] = (seoMore);

/***/ }),

/***/ "./src/js/assets/slider.js":
/*!*********************************!*\
  !*** ./src/js/assets/slider.js ***!
  \*********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);


var pureSlider = function pureSlider(slidesTag, type, style, items) {
  var noTouch = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;
  var height = arguments.length > 5 ? arguments[5] : undefined;
  var autoPlaytime = arguments.length > 6 ? arguments[6] : undefined;
  var pure = document.querySelectorAll(slidesTag);

  if (pure) {
    if (style === 'classic') {
      pure.forEach(function (slider) {
        var btnNext = slider.nextElementSibling.children[0],
            btnPrev = slider.nextElementSibling.children[2];

        if (type === 'dots') {
          for (var i = 0; i < slider.children.length; i++) {
            var dot = document.createElement('div');
            dot.setAttribute('class', 'dot');
            slider.nextElementSibling.nextElementSibling.appendChild(dot);
            dot.setAttribute('data-slide-to', i + 1);
          }

          slider.parentElement.querySelector('.dot').classList.add('dot_active');
          window.addEventListener('resize', function () {
            var dots = slider.parentElement.querySelectorAll('.dot');

            if (dots) {
              dots.forEach(function (dot) {
                return dot.remove();
              });
            }

            for (var _i = 0; _i < slider.children.length; _i++) {
              var _dot = document.createElement('div');

              _dot.setAttribute('class', 'dot');

              slider.nextElementSibling.nextElementSibling.appendChild(_dot);

              _dot.setAttribute('data-slide-to', _i + 1);
            }

            slider.parentElement.querySelector('.dot').classList.add('dot_active');
          });
        }

        if (type === 'imgs') {
          for (var _i2 = 0; _i2 < slider.children.length; _i2++) {
            var img = document.createElement('div');
            img.setAttribute('class', 'product-imgs-mini__block');
            var picture = document.createElement('img');
            picture.setAttribute('src', slider.children[_i2].children[0].src);
            slider.parentElement.nextElementSibling.appendChild(img);
            img.appendChild(picture);
            picture.setAttribute('data-slide-to', _i2 + 1);
          }

          slider.parentElement.parentElement.querySelector('.product-imgs-mini__block').classList.add('active');
        }

        if (type == 'multiple') {
          var createMultipleDots = function createMultipleDots() {
            for (var _i3 = 0; _i3 < slider.children[0].clientWidth * slider.children.length / slider.clientWidth; _i3++) {
              var _dot2 = document.createElement('div');

              if (items == 'items') {
                _dot2.setAttribute('class', 'dot');

                slider.nextElementSibling.children[1].appendChild(_dot2);
              } else {
                _dot2.setAttribute('class', 'reviews-dots__dot');

                slider.nextElementSibling.nextElementSibling.appendChild(_dot2);
              }

              _dot2.setAttribute('data-slide-to', _i3 + 1);
            }

            if (items == 'items') {
              slider.parentElement.querySelector('.dot').classList.add('dot_active');
            } else {
              slider.parentElement.querySelector('.reviews-dots__dot').classList.add('active');
            }
          };

          createMultipleDots();
          window.addEventListener('resize', function () {
            var dots = slider.parentElement.querySelectorAll('.dot');
            var reviewDots = slider.parentElement.querySelectorAll('.reviews-dots__dot');

            if (dots || reviewDots) {
              if (dots) {
                dots.forEach(function (i) {
                  return i.remove();
                });
              }

              if (reviewDots) {
                reviewDots.forEach(function (i) {
                  return i.remove();
                });
              }

              createMultipleDots();
            }
          });
        }

        if (height == true) {
          window.addEventListener('resize', function () {
            if (document.documentElement.clientWidth > 576) {
              slider.style.pointerEvents = 'none';
            } else {
              slider.style.pointerEvents = 'unset';
            }
          });
        }

        var viewport = slider.parentElement.offsetWidth,
            viewSlide = 0;
        window.addEventListener('resize', function () {
          updateViewport();
        });

        function updateViewport() {
          viewport = slider.parentElement.offsetWidth;
          slider.style.transform = "translateX(0px)";
          return viewport;
        }

        slider.style.transform = '.translateX(0)';
        var dots = slider.parentElement.querySelectorAll('.dot'),
            multipleDots = slider.parentElement.querySelectorAll('.reviews-dots__dot');
        window.addEventListener('resize', function () {
          return dots = slider.parentElement.querySelectorAll('.dot'), multipleDots = slider.parentElement.querySelectorAll('.reviews-dots__dot');
        });
        var dashes = slider.parentElement.parentElement.querySelectorAll('.i');
        var imgs = slider.parentElement.parentElement.querySelectorAll('.product-imgs-mini__block');

        function prevSlide() {
          if (viewSlide < slider.children.length - 1 && !(type == "multiple")) {
            viewSlide++;
          } else if (type == "multiple" && viewSlide < Math.floor(slider.children[0].clientWidth * slider.children.length) / slider.clientWidth - 1) {
            viewSlide++;
          } else {
            viewSlide = 0;
          }

          if (type === 'dots') {
            dots.forEach(function (dot) {
              return dot.classList.remove('dot_active');
            });
            dots[viewSlide].classList.add('dot_active');
            slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
          }

          if (type === 'i') {
            dashes.forEach(function (dash) {
              return dash.classList.remove('active');
            });
            dashes[viewSlide].classList.add('active');
            slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
          }

          if (type === 'imgs') {
            imgs.forEach(function (img) {
              return img.classList.remove('active');
            });
            imgs[viewSlide].classList.add('active');
            slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
          }

          if (type === 'multiple') {
            if (items === 'items') {
              dots.forEach(function (dot) {
                return dot.classList.remove('dot_active');
              });
              dots[viewSlide].classList.add('dot_active');
              slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
            } else {
              multipleDots.forEach(function (dot) {
                return dot.classList.remove('active');
              });
              multipleDots[viewSlide].classList.add('active');
              slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
            }
          }
        }

        function nextSlide() {
          if (viewSlide > 0) {
            viewSlide--;
          } else if (type == 'multiple') {
            viewSlide = Math.floor(slider.children[0].clientWidth * slider.children.length / slider.clientWidth);
          } else {
            viewSlide = slider.children.length - 1;
          }

          if (type === 'dots') {
            dots.forEach(function (dot) {
              return dot.classList.remove('dot_active');
            });
            dots[viewSlide].classList.add('dot_active');
            slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
          }

          if (type === 'i') {
            dashes.forEach(function (dash) {
              return dash.classList.remove('active');
            });
            dashes[viewSlide].classList.add('active');
            slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
          }

          if (type === 'imgs') {
            imgs.forEach(function (img) {
              return img.classList.remove('active');
            });
            imgs[viewSlide].classList.add('active');
            slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
          }

          if (type === 'multiple') {
            if (items === 'items') {
              dots.forEach(function (dot) {
                return dot.classList.remove('dot_active');
              });
              dots[viewSlide].classList.add('dot_active');
              slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
            } else {
              multipleDots.forEach(function (dot) {
                return dot.classList.remove('active');
              });
              multipleDots[viewSlide].classList.add('active');
              slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
            }
          }
        }

        function currentSlide() {
          slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
        }

        if (btnNext && btnPrev) {
          btnNext.addEventListener("click", nextSlide);
          btnPrev.addEventListener("click", prevSlide);
        }

        if (type === 'dots') {
          var addListener = function addListener() {
            dots.forEach(function (dot) {
              dot.addEventListener('click', function (e) {
                var slideTo = e.target.getAttribute('data-slide-to');
                viewSlide = slideTo - 1;
                slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
                dots.forEach(function (dot) {
                  return dot.classList.remove('dot_active');
                });
                dots[viewSlide].classList.add('dot_active');
              });
            });
          };

          addListener();
          window.addEventListener('resize', function () {
            addListener();
          });
        }

        if (type === 'i') {
          dashes.forEach(function (dash) {
            dash.addEventListener('click', function (e) {
              var slideTo = e.target.getAttribute('data-slide-to');
              viewSlide = slideTo - 1;
              slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
              dashes.forEach(function (dash) {
                return dash.classList.remove('active');
              });
              dashes[viewSlide].classList.add('active');
            });
          });
        }

        if (type === 'imgs') {
          imgs.forEach(function (img) {
            img.addEventListener('click', function (e) {
              var slideTo = e.target.getAttribute('data-slide-to');
              viewSlide = slideTo - 1;
              slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
              imgs.forEach(function (img) {
                return img.classList.remove('active');
              });
              imgs[viewSlide].classList.add('active');
            });
          });
        }

        if (type === 'multiple') {
          var _addListener = function _addListener() {
            if (items === 'items') {
              dots.forEach(function (dot) {
                dot.addEventListener('click', function (e) {
                  var slideTo = e.target.getAttribute('data-slide-to');
                  viewSlide = slideTo - 1;
                  slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
                  dots.forEach(function (dot) {
                    return dot.classList.remove('dot_active');
                  });
                  dots[viewSlide].classList.add('dot_active');
                });
              });
            } else {
              multipleDots.forEach(function (dot) {
                dot.addEventListener('click', function (e) {
                  var slideTo = e.target.getAttribute('data-slide-to');
                  viewSlide = slideTo - 1;
                  slider.style.transform = "translateX(".concat(-viewSlide * viewport, "px)");
                  multipleDots.forEach(function (dot) {
                    return dot.classList.remove('active');
                  });
                  multipleDots[viewSlide].classList.add('active');
                });
              });
            }
          };

          _addListener();

          window.addEventListener('resize', function () {
            _addListener();
          });
        }

        function mouseDown(e) {
          if (e.identifier === 0) {
            posx = e.clientX;
            slider.style.transition = '.9s all';
            return posx;
          } else {
            e.preventDefault();
            posx = e.clientX;
            slider.style.transition = '.9s all';
            return posx;
          }
        }

        function mouseUp(e) {
          if (e.clientX - posx < -viewport * 0.2) {
            slider.style.transition = '0.9s';
            prevSlide();
          } else {
            slider.style.transition = '0.9s';
            currentSlide();
          }

          posx = 0;
        }

        function moving(e) {
          function leaving() {
            slider.style.transition = '0.9s';
            currentSlide();
            posx = 0;
          }

          slider.addEventListener('mouseleave', function () {
            leaving();
          });

          if (posx > 0) {
            slider.style.transition = '0s';
            slider.style.transform = "translateX(".concat(-viewSlide * viewport - posx + e.clientX, "px");

            if (-posx + e.clientX < -viewport * 0.3) {
              slider.style.transition = '0.9s';
              prevSlide();
              posx = 0;
            } else if (e.clientX - posx > viewport * 0.3) {
              slider.style.transition = '0.9s';
              nextSlide();
              posx = 0;
            }
          } else if (posx == 0) {
            slider.removeEventListener('mousemove', moving);
            slider.removeEventListener('touchmove', moving);
          }
        }

        if (!noTouch) {
          slider.addEventListener('touchstart', function (e) {
            posx = e.touches[0].clientX;
            slider.style.transition = '.9s all';
            return posx;
          }, {
            passive: true
          });
          slider.addEventListener('touchmove', function (e) {
            moving(e.touches[0]);
          }, {
            passive: true
          });
          slider.addEventListener('touchend', function (e) {
            mouseUp(e);
          });
          slider.addEventListener("mousedown", function (e) {
            mouseDown(e);
          });
          slider.addEventListener('mouseup', function (e) {
            mouseUp(e);
          });
          slider.addEventListener('mousemove', function (e) {
            moving(e);
          });
        }

        if (autoPlaytime) {
          var activateAnimation = function activateAnimation() {
            paused = setInterval(function () {
              prevSlide();
            }, autoPlaytime);
          };

          var paused = false;
          activateAnimation();
          slider.addEventListener('mouseenter', function () {
            clearInterval(paused);
          });
          slider.addEventListener('mouseleave', function () {
            activateAnimation();
          });
        }
      });
    } else if (style === 'opacity') {
      pure.forEach(function (slider) {
        if (type === 'imgs') {
          var _viewSlide = 0;

          for (var i = 0; i < slider.children.length; i++) {
            var img = document.createElement('div');
            img.setAttribute('class', 'product-imgs__mini-item');
            var picture = document.createElement('img');
            picture.setAttribute('src', slider.children[i].src);
            slider.parentElement.previousElementSibling.appendChild(img);
            img.appendChild(picture);
            img.setAttribute('data-slide-to', i + 1);
          }

          slider.parentElement.parentElement.querySelector('.product-imgs__mini-item');
          if(slider.parentElement.parentElement.querySelector('.product-imgs__mini-item')) {
            slider.parentElement.parentElement.querySelector('.product-imgs__mini-item').classList.add('active')
          }

          var _imgs = slider.parentElement.parentElement.querySelectorAll('.product-imgs__mini-item');
          if(_imgs) {
            _imgs.forEach(function (img) {
              return img.classList.remove('active');
            });
            if(_imgs[_viewSlide]) {
              _imgs[_viewSlide].classList.add('active');
            }
          }


          slider.children.forEach(function (item) {
            item.classList.remove('active-slide');
          });

          if(slider.children[_viewSlide]) {
            slider.children[_viewSlide].classList.add('active-slide');
          }

          _imgs.forEach(function (img) {
            img.addEventListener('click', function (e) {
              // console.log(e.target);
              var slideTo = e.target.getAttribute('data-slide-to');
              _viewSlide = slideTo - 1;
              slider.children.forEach(function (item) {
                item.classList.remove('active-slide');
              });
              // console.log(_viewSlide);

              slider.children[_viewSlide].classList.add('active-slide');

              _imgs.forEach(function (img) {
                return img.classList.remove('active');
              });

              _imgs[_viewSlide].classList.add('active');
            });
          });
        }

        if (type === 'dots') {
          for (var _i4 = 0; _i4 < slider.children.length; _i4++) {
            var dot = document.createElement('div');
            dot.setAttribute('class', 'dot');
            slider.nextElementSibling.appendChild(dot);
            dot.setAttribute('data-slide-to', _i4 + 1);
          }

          slider.parentElement.querySelector('.dot').classList.add('dot_active');
        }

        var imgs = slider.parentElement.parentElement.querySelectorAll('.product-imgs__mini-item');
        var viewSlide = 0,
            viewport = slider.parentElement.offsetWidth,
            posx = 0,
            paused = false;

        function prevSlide() {
          if (viewSlide > 0) {
            viewSlide--;
          } else {
            viewSlide = slider.children.length - 1;
          }

          if (type === 'imgs') {
            imgs.forEach(function (img) {
              img.classList.remove('active');
            });

            if (viewSlide > 0) {
              imgs[viewSlide].classList.add('active');
            } else {
              imgs[slider.children.length - 1].classList.add('active');
            }
          }

          if (type === 'dots') {
            dots.forEach(function (dot) {
              return dot.classList.remove('dot_active');
            });
            dots[viewSlide].classList.add('dot_active');
          }

          slider.children.forEach(function (item) {
            return item.classList.remove('active-slide');
          });
          slider.children[viewSlide].classList.add('active-slide');
          ;
        }

        function nextSlide() {
          if (viewSlide < slider.children.length) {
            viewSlide++;
          } else {
            viewSlide = 0;
          }

          if (type === 'dots') {
            dots.forEach(function (dot) {
              return dot.classList.remove('dot_active');
            });

            if (dots[viewSlide]) {
              dots[viewSlide].classList.add('dot_active');
            } else {
              dots[0].classList.add('dot_active');
            }
          }

          if (type === 'imgs') {
            imgs.forEach(function (img) {
              img.classList.remove('active');
            });

            if (viewSlide < slider.children.length) {
              imgs[viewSlide].classList.add('active');
            } else {
              imgs[0].classList.add('active');
            }
          }

          slider.children.forEach(function (item) {
            return item.classList.remove('active-slide');
          });

          if (slider.children[viewSlide]) {
            slider.children[viewSlide].classList.add('active-slide');
          } else {
            slider.children[0].classList.add('active-slide');
          }
        } // let viewport = slider.parentElement.offsetWidth;


        function mouseDown(e) {
          if (e.identifier === 0) {
            posx = e.clientX;
            slider.style.transition = '.9s all';
            // console.log(posx);
            return posx;
          } else {
            e.preventDefault();
            // console.log(posx);
            posx = e.clientX;
            slider.style.transition = '.9s all';
            return posx;
          }
        }

        function mouseUp(e) {
          // console.log(viewport);
          // console.log(posx);
          return posx;
        }

        function moving(e) {
          function leaving() {
            slider.style.transition = '0.9s';
            posx = 0;
          }

          slider.addEventListener('mouseleave', function () {
            leaving();
          });

          if (posx > 0) {
            slider.style.transition = '0s';

            if (-posx + e.clientX < -viewport * 0.3) {
              slider.style.transition = '0.9s';
              nextSlide();
              posx = 0;
            } else if (e.clientX - posx > viewport * 0.3) {
              slider.style.transition = '0.9s';
              prevSlide();
              posx = 0;
            }
          } else if (posx == 0) {
            slider.removeEventListener('mousemove', moving);
            slider.removeEventListener('touchmove', moving);
          }
        }

        if (!noTouch) {
          slider.addEventListener('touchstart', function (e) {
            posx = e.touches[0].clientX;
            slider.style.transition = '.9s all';
            return posx;
          }, {
            passive: true
          });
          slider.addEventListener('touchmove', function (e) {
            moving(e.touches[0]);
          }, {
            passive: true
          });
          slider.addEventListener('touchend', function (e) {
            mouseUp(e);
          });
          slider.addEventListener("mousedown", function (e) {
            mouseDown(e);
          });
          slider.addEventListener('mouseup', function (e) {
            mouseUp(e);
          });
          slider.addEventListener('mousemove', function (e) {
            moving(e);
          });
        }

        var dots = slider.parentElement.querySelectorAll('.dot');

        if (type === 'dots') {
          var addListener = function addListener() {
            dots.forEach(function (dot) {
              dot.addEventListener('click', function (e) {
                var slideTo = e.target.getAttribute('data-slide-to');
                viewSlide = slideTo - 1;
                slider.children.forEach(function (item) {
                  return item.classList.add('disabled');
                });
                slider.children[viewSlide].classList.remove('disabled');
                dots.forEach(function (dot) {
                  return dot.classList.remove('dot_active');
                });
                dots[viewSlide].classList.add('dot_active');
              });
            });
          };

          addListener();
          window.addEventListener('resize', function () {
            addListener();
          });
        }
      });
    }
  }
};

/* harmony default export */ __webpack_exports__["default"] = (pureSlider);

/***/ }),

/***/ "./src/js/assets/validation.js":
/*!*************************************!*\
  !*** ./src/js/assets/validation.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.regexp.constructor.js */ "./node_modules/core-js/modules/es.regexp.constructor.js");
/* harmony import */ var core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.regexp.to-string.js */ "./node_modules/core-js/modules/es.regexp.to-string.js");
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_string_trim_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.string.trim.js */ "./node_modules/core-js/modules/es.string.trim.js");
/* harmony import */ var core_js_modules_es_string_trim_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_trim_js__WEBPACK_IMPORTED_MODULE_4__);






var validation = function validation() {
  var forms = document.querySelectorAll('form:not(.checkout-block, .contact-form, .certificate-form)');
  forms.forEach(function (form) {
    var names = form.querySelectorAll('.name-input'),
        phone = form.querySelectorAll('.phone-input'),
        messages = form.querySelectorAll('.message-input'),
        emails = form.querySelectorAll('.email-input'),
        phoneRegEx = new RegExp(/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){9,14}(\s*)?$/),
        emailRegEx = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/),
        clean = form.querySelector('.btn_clean');
    var errorName = false,
        errorMessage = false,
        errorPhone = false,
        errorEmail = false,
        errorAddress = false,
        errorCountry = false,
        errorState = false,
        errorCity = false,
        errorPostal = false,
        errorDelivery = false,
        errorPrice = false,
        errorPayment = false;
    var input = form.querySelectorAll('input');

    if (clean) {
      clean.addEventListener('click', function () {
        input.forEach(function (item) {
          item.value = '';

          if (item.type === 'checkbox' || item.type === 'radio') {
            item.checked = false;
          }
        });
      });
    }

    function removeError(item) {
      if (item.value.trim().length > 0) {
        item.classList.remove('wrong');
        item.parentElement.classList.remove('wrong');
        var span = item.parentElement.querySelector('.span_error');

        if (span) {
          span.remove();
        }
      }
    }

    function check(attr, regEx, type, char) {
      if (attr) {
        attr.forEach(function (i) {
          i.addEventListener('input', function () {
            if (type === 'regEx' && regEx.test(i.value)) {
              removeError(i);

              if (attr === phone) {
                return errorPhone = false;
              }

              if (attr === emails) {
                return errorEmail = false;
              }
            }

            if (type === 'length') {
              if (i.value.length >= char) {
                removeError(i);

                if (attr === messages) {
                  return errorMessage = false;
                }

                if (attr === names) {
                  return errorName = false;
                }

                if (attr === address) {
                  return errorAddress = false;
                }

                if (attr === price) {
                  return errorPrice = false;
                }
              }
            }
          });
        });
      }
    }

    check(emails, emailRegEx, 'regEx');
    check(phone, phoneRegEx, 'regEx');
    check(messages, '', 'length', 10);
    check(names, '', 'length', 2);

    function showError(item, message, type) {
      var error = document.createElement('span');
      error.setAttribute('class', 'span_error');
      item.classList.add('wrong');
      item.parentElement.insertAdjacentElement('beforeend', error);
      error.innerHTML = message;
    }

    var btn = form.querySelector('button');

    if (btn) {
      btn.addEventListener('click', function () {
        function errorMessageFunction(attr, type, char, message, regEx) {
          if (attr) {
            attr.forEach(function (item) {
              var error = item.parentElement.querySelector('.span_error');

              if (type === 'length') {
                if (item.value.trim().length < char && !error) {
                  showError(item, message);

                  if (attr === names) {
                    return errorName = true;
                  }

                  if (attr === messages) {
                    return errorMessage = true;
                  }

                  if (attr === address) {
                    return errorAddress = true;
                  }

                  if (attr === price) {
                    return errorPrice = true;
                  }
                }
              }

              if (type === 'regex') {
                if (!regEx.test(item.value) && !error) {
                  showError(item, message);

                  if (attr === phone) {
                    return errorPhone = true;
                  }

                  if (attr === emails) {
                    return errorEmail = true;
                  }
                }
              }
            });
          }
        }

        errorMessageFunction(names, 'length', 2, "Name is not correct (minimum length - 2 symbols)");
        errorMessageFunction(messages, 'length', 10, "Please describe your problem <br>(minimum length - 10 symbols)");
        errorMessageFunction(phone, 'regex', 0, "\u0412\u0432\u0435\u0434\u0438\u0442\u0435 \u043A\u043E\u0440\u0440\u0435\u043A\u0442\u043D\u044B\u0439 \u043D\u043E\u043C\u0435\u0440 \u0442\u0435\u043B\u0435\u0444\u043E\u043D\u0430", phoneRegEx);
        errorMessageFunction(emails, 'regex', 0, "\u0412\u0432\u0435\u0434\u0438\u0442\u0435 \u043A\u043E\u0440\u0440\u0435\u043A\u0442\u043D\u044B\u0439 \u0430\u0434\u0440\u0435\u0441 \u044D\u043B\u0435\u043A\u0442\u0440\u043E\u043D\u043D\u043E\u0439 \u043F\u043E\u0447\u0442\u044B", emailRegEx);
      });
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      input.forEach(function (input) {
        input.classList.remove('editable');
      });


      if (!errorName && !errorPrice && !errorMessage && !errorPhone && !errorEmail && !errorAddress && !errorCountry && !errorState && !errorCity && !errorPostal && !errorDelivery && !errorPayment) {
        console.log(true);
      }
    });
  });
};

/* harmony default export */ __webpack_exports__["default"] = (validation);

/***/ }),

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _assets_faq__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./assets/faq */ "./src/js/assets/faq.js");
/* harmony import */ var _assets_slider__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./assets/slider */ "./src/js/assets/slider.js");
/* harmony import */ var _assets_amount__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./assets/amount */ "./src/js/assets/amount.js");
/* harmony import */ var _assets_certificate__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./assets/certificate */ "./src/js/assets/certificate.js");
/* harmony import */ var _assets_range__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./assets/range */ "./src/js/assets/range.js");
/* harmony import */ var _assets_dropdown__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./assets/dropdown */ "./src/js/assets/dropdown.js");
/* harmony import */ var _assets_calc__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./assets/calc */ "./src/js/assets/calc.js");
/* harmony import */ var _assets_appenChildSlider__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./assets/appenChildSlider */ "./src/js/assets/appenChildSlider.js");
/* harmony import */ var _assets_fixedScroll__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./assets/fixedScroll */ "./src/js/assets/fixedScroll.js");
/* harmony import */ var _assets_cabinetScript__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./assets/cabinetScript */ "./src/js/assets/cabinetScript.js");
/* harmony import */ var _assets_validation__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./assets/validation */ "./src/js/assets/validation.js");
/* harmony import */ var _assets_filtersOpen__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./assets/filtersOpen */ "./src/js/assets/filtersOpen.js");
/* harmony import */ var _assets_mobileMenu__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./assets/mobileMenu */ "./src/js/assets/mobileMenu.js");
/* harmony import */ var _assets_backBtn__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./assets/backBtn */ "./src/js/assets/backBtn.js");
/* harmony import */ var _assets_seoMore__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./assets/seoMore */ "./src/js/assets/seoMore.js");















document.addEventListener('DOMContentLoaded', function () {
  // pureSlider('.big-slider__slides', 'dots', 'classic', false, false, false, 5000);
  Object(_assets_appenChildSlider__WEBPACK_IMPORTED_MODULE_7__["default"])({
    sliderSelector: '.big-slider__wrapper',
    btnLeftSelector: '.left',
    btnRightSelector: '.right',
    itemSelector: '.big-slider__slide',
    transitionTime: '.9',
    dots: '.dots',
    autoScroll: 6000
  }); // var i = 'dssdadas';
  // i.split();
  // console.log(i.split())

  Object(_assets_slider__WEBPACK_IMPORTED_MODULE_1__["default"])('.product-imgs__block', 'imgs', 'opacity');
  Object(_assets_faq__WEBPACK_IMPORTED_MODULE_0__["default"])();
  Object(_assets_amount__WEBPACK_IMPORTED_MODULE_2__["default"])();
  Object(_assets_certificate__WEBPACK_IMPORTED_MODULE_3__["default"])();
  Object(_assets_range__WEBPACK_IMPORTED_MODULE_4__["default"])();
  Object(_assets_dropdown__WEBPACK_IMPORTED_MODULE_5__["default"])();
  var sizesData = {
    chest: {
      'AA': [10, 11],
      'A': [12, 13],
      'B': [14, 15],
      'C': [16, 17],
      'D': [18, 19],
      'E': [20, 21],
      'F': [22, 23],
      'G': [24, 25],
      'H': [26, 27],
      'I': [28, 29]
    },
    hip: {
      'XS': [86, 90],
      'S': [91, 94],
      'M': [95, 98],
      'L': [99, 106],
      'XL': [107, 114],
      'XXL': [115, 122],
      '3XL': [123, 130],
      '4XL': [131, 138]
    },
    chestNew: {
      "A": {
        "OPG": [70, 71, 72, 73, 74, 75],
        "OG": [80, 81, 82, 83, 84, 85]
      },
      "B": {
        "OPG": [75, 76, 77, 78],
        "OG": [86, 87, 88, 89, 90, 91, 92, 93]
      },
      "C": {
        "OPG": [77, 78, 79, 80, 85],
        "OG": [94, 95, 96, 97, 98]
      },
      "D": {
        "OPG": [82, 83, 84, 85, 86, 87, 88, 89, 90],
        "OG": [92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]
      },
      "D+": {
        "OPG": [90, 91, 92, 93, 94, 95],
        "OG": [105, 106, 107, 108, 109, 110]
      },
      "E": {
        "OPG": [92, 93, 94, 95, 96, 97, 98, 99, 100],
        "OG": [110, 111, 112, 113, 114, 115, 116, 117, 120]
      },
      "E+": {
        "OPG": [95, 96, 97],
        "OG": [115, 116, 117, 118, 119, 120]
      },
      "F": {
        "OPG": [97, 101],
        "OG": [120,121,122,123,124,125,126,127,128,129,130]
      },
      "F+": {
        "OPG": [102],
        "OG": [131]
      },
      "G": {
        "OPG": [102],
        "OG": [131, 132, 133, 134, 135]
      }
    }
  };

  const popupNew = document.querySelector(".new-popup__overflow")
  if(popupNew) {
    if(!window.localStorage.getItem("firstTime")) {
      popupNew.style.opacity = "1";
      popupNew.style.visibility = "visible";
      window.localStorage.setItem("firstTime", true);
      const closeBtn = popupNew.querySelector(".new-popup__close")
      const okBtn = popupNew.querySelector(".btn")
      if(closeBtn) {
        closeBtn.addEventListener("click", function () {
          popupNew.remove()
        })
      }
      if(okBtn) {
        okBtn.addEventListener("click", function () {
          popupNew.remove()
        })
      }
      popupNew.addEventListener("click", function(e) {
        if(e.target === popupNew) {
          popupNew.remove()
        }
      })
      document.addEventListener("keydown", function(e) {
        if(e.key === "Escape") {
          if(popupNew) {
            popupNew.remove()
          }
        }
      })
    }
  }



  if (document.documentElement.clientWidth < 768) {
    var slider = document.querySelector('.extra__slider');
    var slider2 = document.querySelector('.similar__slider');

    if (slider) {
      slider.classList.remove('extra__slider');
      slider.classList.add('extra__slider-mobile');
    }

    if (slider2) {
      slider2.classList.remove('similar__slider');
      slider2.classList.add('extra__slider-mobile');
    }
  }

  window.addEventListener('resize', function () {
    if (document.documentElement.clientWidth < 768) {
      var _slider = document.querySelector('.extra__slider');

      var _slider2 = document.querySelector('.similar__slider');

      if (_slider2) {
        _slider2.classList.remove('similar__slider');

        _slider2.classList.add('extra__slider-mobile');
      }

      if (_slider) {
        _slider.classList.remove('extra__slider');

        _slider.classList.add('extra__slider-mobile');
      }
    }
  });
  
  // var accountBtns = document.querySelectorAll(".account-info__block .btn")
  // if(accountBtns[0]) {
  //   accountBtns.forEach(function(btn) {
  //     var editBlock = btn.parentElement.nextElementSibling
  //     btn.addEventListener("click", function(e) {
  //       e.preventDefault();
  //       if(editBlock.classList.contains('account-info__edit')) {
  //         editBlock.classList.toggle('account-info__edit_visible')
  //       }
  //     })
  //   })
  // }
  document.addEventListener("click", function(e) {
    if(e.target.classList.contains('btn') && e.target.parentElement.parentElement && e.target.parentElement.parentElement.classList.contains('account-info__block--p')) {
      e.preventDefault();
      var editBlock = e.target.parentElement.parentElement.nextElementSibling
      if(editBlock.style.display === 'block') {
          editBlock.style.display = 'none'
      } else {
          editBlock.style.display = 'block';
          e.target.parentElement.parentElement.style.display = 'none'
      }
    }
      var inputs = document.querySelectorAll("#collapse-shipping-method input");
    if(inputs[0])
    inputs.forEach(input => {
      if(input.nextElementSibling) {
        var instruction = input.nextElementSibling.querySelector('.pickup-pickup-instruction');
        if(instruction) {
          if(input.checked) {
            instruction.classList.add('pickup-pickup-instruction_active')
          } else {
            instruction.classList.remove('pickup-pickup-instruction_active')
          }
        }
      }


    })

  })
  var addressBtn = document.querySelector('.account-info__block--a .btn')
  if(addressBtn) {
    addressBtn.addEventListener("click", function(e) {
      e.preventDefault();
      var editBlock = addressBtn.parentElement.nextElementSibling;
      if(editBlock.style.display === 'block') {
        editBlock.style.display = 'none'
      } else {
        editBlock.style.display = 'block'
        addressBtn.parentElement.style.display = 'none'

      }

    })
  }

  var topBtn = document.querySelector(".top-btn");
  if(topBtn) {
    topBtn.addEventListener("click", function(e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    })
    if(document.body.clientHeight > (document.documentElement.clientHeight * 1.4)) {
      document.addEventListener("scroll", function() {
        if(window.pageYOffset > 150) {
          topBtn.classList.add("top-btn_active")
        } else {
          topBtn.classList.remove("top-btn_active")
        }
      })
    }
  }


    document.addEventListener("click", function(e) {
      if(e.target.classList.contains("tooltip-toggle")) {
        e.preventDefault()
        if(document.documentElement.clientWidth < 993) {
          e.target.nextElementSibling.classList.toggle("active")
        }
      }
    })

  document.addEventListener("click", function(e) {
    if(e.target.classList.contains("icons-btn")) {
      e.target.parentElement.classList.toggle("active");
      var topBtn = document.querySelector(".top-btn");
      if(e.target.parentElement.classList.contains("active")) {
        topBtn.style.display = "none";
      } else {
        topBtn.style.display = "flex"
      }
    }
  })
  var chatBtn = document.querySelector("#retailcrm-consultant-app");
  console.log(chatBtn);
  var myInterval = setInterval(findChat, 500)

  function findChat() {
    var chatBtn = document.querySelector("#retailcrm-consultant-app");
    if(chatBtn) {
      var chatIcons = document.querySelector(".icons-icons")
      if(chatIcons) {
        chatIcons.insertAdjacentElement("afterbegin", chatBtn)
      }
      clearInterval(myInterval)
    }
  }

  var accountPassBtn = document.querySelector(".account-info__change");
  if(accountPassBtn) {
    accountPassBtn.addEventListener("click", function(e) {
      e.preventDefault();
      var editBlock = accountPassBtn.nextElementSibling;
      if(editBlock.style.display === 'block') {
        editBlock.style.display = 'none'
      } else {
        editBlock.style.display = 'block'
      }
    })
  }
  // var executive = false;
    function findBtn (selector, text) {
      var freeBtn = document.querySelector(selector)
      if(freeBtn) {
        if(!freeBtn.nextElementSibling || !freeBtn.nextElementSibling.classList.contains("free-instruction")) {
          var instruction = document.createElement("span")
          instruction.classList.add("free-instruction")
          freeBtn.insertAdjacentElement("afterend", instruction);
          instruction.innerHTML = text;
        }
      }
    }
  function findMkadBtn(selector, text) {
    var btn = document.querySelector(selector);
    if(btn) {
      if(!btn.querySelector(".pickup-pickup-instruction")) {
        var instruction = document.createElement("span")
        instruction.classList.add("pickup-pickup-instruction")
        btn.insertAdjacentElement("beforeend", instruction);
        instruction.innerHTML = text;
      }
    }
  }

  var checkoutPage = document.querySelector(".checkout__info")
    if(checkoutPage) {
      setInterval(function(){findBtn('[data-code="free.free"] .custom-radio__text', `Курьером по Минску - 0 BYN <br><br> Для других городов Беларуси по почте - 0 BYN`)}, 500)
      setInterval(function() {findMkadBtn('[data-code="flat.flat"] .custom-radio__text', `Дни доставки: понедельник, среда, пятница, воскресенье. <br>Время доставки: с 18:00 до 22:00. Вы можете написать удобное для вас время и день в поле Комментарий.`)}, 500)
      setInterval(function() {findMkadBtn('[data-code="flat2.flat2"] .custom-radio__text', `Дни доставки: понедельник, среда, пятница, воскресенье. <br>Время доставки: с 18:00 до 22:00. Вы можете написать удобное для вас время и день в поле Комментарий.`)}, 500)
    }




  
  var forgotLink = document.querySelector('.forgot');

  if (forgotLink) {
    forgotLink.addEventListener('click', function (e) {
      e.preventDefault();
      var loginForm = document.querySelector('.login__login');
      loginForm.style.display = 'none';
      loginForm.nextElementSibling.style.display = 'block';
      var loginFirst = document.querySelector('.login__first');
      loginFirst.style.display = 'none';
      loginFirst.nextElementSibling.style.display = 'block';
    });
  }

  Object(_assets_calc__WEBPACK_IMPORTED_MODULE_6__["default"])(sizesData);
  Object(_assets_appenChildSlider__WEBPACK_IMPORTED_MODULE_7__["default"])({
    sliderSelector: '.extra__slider',
    btnLeftSelector: '.left',
    btnRightSelector: '.right',
    itemSelector: '.item',
    transitionTime: '.5',
    displayedSlides: 4
  });
  Object(_assets_appenChildSlider__WEBPACK_IMPORTED_MODULE_7__["default"])({
    sliderSelector: '.similar__slider',
    amount: 2,
    btnLeftSelector: '.left',
    btnRightSelector: '.right',
    itemSelector: '.item',
    transitionTime: '.5',
    displayedSlides: 4
  });
  Object(_assets_fixedScroll__WEBPACK_IMPORTED_MODULE_8__["default"])('.account__menu', 20, 270);
  Object(_assets_fixedScroll__WEBPACK_IMPORTED_MODULE_8__["default"])('.product .product-imgs', 20, 240);
  Object(_assets_cabinetScript__WEBPACK_IMPORTED_MODULE_9__["default"])();
  Object(_assets_validation__WEBPACK_IMPORTED_MODULE_10__["default"])();
  Object(_assets_filtersOpen__WEBPACK_IMPORTED_MODULE_11__["default"])();
  Object(_assets_mobileMenu__WEBPACK_IMPORTED_MODULE_12__["default"])();
  Object(_assets_backBtn__WEBPACK_IMPORTED_MODULE_13__["default"])();
  Object(_assets_seoMore__WEBPACK_IMPORTED_MODULE_14__["default"])();

  //Turn subscription tab

  const queryString = window.location.search;
  if(queryString) {
    const urlParams = new URLSearchParams(queryString);
    urlParams.get('subscription')
    var subscriptionBtn = document.querySelector(".account__subscription");
    if(urlParams.get('subscription')) {
      if(subscriptionBtn) {
        subscriptionBtn.click();
      }
    }
  }
  const subscriptionAnchor = document.querySelector(".subscription-anchor");
  if(subscriptionAnchor) {
    subscriptionAnchor.addEventListener('click', function(e) {
      e.preventDefault();
      const anchorBlock = document.querySelector("#" + subscriptionAnchor.getAttribute("data-link"))
      if(anchorBlock) {
        const top = anchorBlock.getBoundingClientRect().top;
        window.scrollTo({
          top: top,
          behavior: "smooth"
        })
      }
    })
  }

});

/***/ })

/******/ });
//# sourceMappingURL=script.js.map
