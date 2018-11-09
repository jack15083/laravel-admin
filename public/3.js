webpackJsonp([3],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/system/logs.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        this.getList();
    },
    data: function data() {
        return {
            tableData: [],
            form: {
                page: 1,
                pageSize: 20
            },
            totalItems: 0
        };
    },

    methods: {
        onSearch: function onSearch() {
            this.form.page = 1;
            this.getList();
        },
        getList: function getList() {
            var _this = this;

            this.$http.get('/api/system/admin/loglist', this.form).then(function (res) {
                _this.tableData = res.data.data;
                _this.totalItems = res.data.total;
            });
        },
        handleSizeChange: function handleSizeChange(size) {
            this.form.pageSize = size;
            this.getList();
        },
        handleCurrentChange: function handleCurrentChange(page) {
            this.form.page = page;
            this.getList();
        }
    }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-393898ac\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/system/logs.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "el-form",
        { attrs: { inline: true, model: _vm.form, size: "small" } },
        [
          _c(
            "el-form-item",
            { attrs: { label: "管理员ID" } },
            [
              _c("el-input", {
                attrs: { placeholder: "管理员ID" },
                model: {
                  value: _vm.form.admin_id,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "admin_id", $$v)
                  },
                  expression: "form.admin_id"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "el-form-item",
            { attrs: { label: "API路径" } },
            [
              _c("el-input", {
                attrs: { placeholder: "请输入API路径" },
                model: {
                  value: _vm.form.func,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "func", $$v)
                  },
                  expression: "form.func"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "el-form-item",
            [
              _c(
                "el-button",
                { attrs: { type: "primary" }, on: { click: _vm.onSearch } },
                [_vm._v("查询")]
              )
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "el-table",
        { attrs: { data: _vm.tableData } },
        [
          _c("el-table-column", {
            attrs: { prop: "id", label: "ID", width: "80" }
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "operator", width: "150", label: "操作者" }
          }),
          _vm._v(" "),
          _c("el-table-column", { attrs: { prop: "func", label: "API路径" } }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "details", label: "请求参数" }
          }),
          _vm._v(" "),
          _c("el-table-column", { attrs: { prop: "ip", label: "操作IP" } }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "create_time", label: "操作时间" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c(
        "el-row",
        [
          _c(
            "el-col",
            { attrs: { span: 13, offset: 11 } },
            [
              _c("el-pagination", {
                attrs: {
                  background: "",
                  "current-page": _vm.form.page,
                  "page-sizes": [25, 50, 100],
                  "page-size": _vm.form.pageSize,
                  layout: "total, sizes, prev, pager, next, jumper",
                  total: _vm.totalItems
                },
                on: {
                  "size-change": _vm.handleSizeChange,
                  "current-change": _vm.handleCurrentChange
                }
              })
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("br")
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-393898ac", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/views/system/logs.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/system/logs.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-393898ac\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/system/logs.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/views/system/logs.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-393898ac", Component.options)
  } else {
    hotAPI.reload("data-v-393898ac", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});