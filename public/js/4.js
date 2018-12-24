webpackJsonp([4],{

/***/ 206:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(75)
/* script */
var __vue_script__ = __webpack_require__(217)
/* template */
var __vue_template__ = __webpack_require__(218)
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
Component.options.__file = "resources/assets/js/views/system/group.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2376835c", Component.options)
  } else {
    hotAPI.reload("data-v-2376835c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 217:
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
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        this.getList();
        this.getRulesTree();
    },
    data: function data() {
        return {
            tableData: [],
            form: {},
            addNewDialog: false,
            saveForm: {
                title: '',
                rules: [],
                status: true
            },
            menusTree: [],
            rulesTree: [],
            auth: {},
            rulesForm: {
                title: [{ required: true, message: '请输入管理组名称', trigger: 'blur' }],
                menus: [{ required: true, message: '请选择菜单', trigger: 'blur' }],
                rules: [{ required: true, message: '请选择权限', trigger: 'blur' }]
            }
        };
    },

    methods: {
        onSearch: function onSearch() {
            this.getList();
        },
        onSubmit: function onSubmit() {
            var _this = this;

            this.getCheckedKeys();

            this.$refs['saveForm'].validate(function (valid) {
                if (valid) {
                    _this.$http.post('/api/system/group/save', _this.saveForm).then(function (res) {
                        if (res.error === 0) {
                            _this.$message({
                                message: '保存成功',
                                type: 'success'
                            });
                            _this.addNewDialog = false;
                            _this.getList();
                        } else {
                            _this.$message({
                                message: res.msg,
                                type: 'error'
                            });
                        }
                    });
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        getList: function getList() {
            var _this2 = this;

            this.$http.get('/api/system/group/list', this.form).then(function (res) {
                _this2.tableData = res.data.list;
                _this2.auth = res.data.auth;
            });
        },
        getRulesTree: function getRulesTree() {
            var _this3 = this;

            this.$http.get('/api/system/rule/list', { status: 1 }).then(function (res) {
                _this3.rulesTree = res.data.list;
            });
        },
        handleAdd: function handleAdd() {
            this.addNewDialog = true;
            if (typeof this.$refs['saveForm'] !== 'undefined') this.$refs['saveForm'].resetFields();
            this.saveForm = {
                title: '',
                rules: [],
                menus: [],
                status: true
            };
            if (typeof this.$refs.tree !== 'undefined') this.$refs.tree.setCheckedKeys([]);
        },
        editGroup: function editGroup(row) {
            this.addNewDialog = true;
            if (typeof this.$refs['saveForm'] !== 'undefined') this.$refs['saveForm'].resetFields();

            this.saveForm = {
                id: row.id,
                title: row.title,
                rules: row.rules,
                status: row.status === 1
            };

            if (typeof this.$refs.tree !== 'undefined') this.$refs.tree.setCheckedKeys(this.saveForm.rules);
        },
        getCheckedKeys: function getCheckedKeys() {
            this.saveForm.rules = this.$refs.tree.getCheckedKeys();
        }
    }
});

/***/ }),

/***/ 218:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("el-alert", {
        attrs: { title: "注意：上帝组拥有至高无上的权限.", type: "info" }
      }),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c(
        "el-form",
        { attrs: { inline: true, model: _vm.form, size: "small" } },
        [
          _c(
            "el-form-item",
            { attrs: { label: "ID" } },
            [
              _c("el-input", {
                attrs: { placeholder: "ID" },
                model: {
                  value: _vm.form.id,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "id", $$v)
                  },
                  expression: "form.id"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "el-form-item",
            { attrs: { label: "组名" } },
            [
              _c("el-input", {
                attrs: { placeholder: "请输入权限组名" },
                model: {
                  value: _vm.form.title,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "title", $$v)
                  },
                  expression: "form.title"
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
        "el-row",
        [
          _vm.auth.canAdd
            ? _c(
                "el-button",
                {
                  attrs: { type: "primary", size: "small" },
                  on: { click: _vm.handleAdd }
                },
                [_vm._v("新增")]
              )
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "el-table",
        {
          staticStyle: { "max-width": "900px" },
          attrs: { data: _vm.tableData }
        },
        [
          _c("el-table-column", {
            attrs: { prop: "id", label: "ID", width: "100" }
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "title", label: "权限组名" }
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { label: "组状态", width: "150" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(scope) {
                  return [
                    scope.row.status == 1
                      ? _c(
                          "el-tag",
                          { attrs: { type: "success", size: "small" } },
                          [_vm._v("已启用")]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    scope.row.status == 0
                      ? _c(
                          "el-tag",
                          { attrs: { type: "info", size: "small" } },
                          [_vm._v("已禁用")]
                        )
                      : _vm._e()
                  ]
                }
              }
            ])
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { fixed: "right", label: "操作", width: "100" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(scope) {
                  return [
                    scope.row.id != 1 && _vm.auth.canEdit
                      ? _c(
                          "el-button",
                          {
                            attrs: { type: "text", size: "small" },
                            on: {
                              click: function($event) {
                                _vm.editGroup(scope.row)
                              }
                            }
                          },
                          [_vm._v("编辑")]
                        )
                      : _vm._e()
                  ]
                }
              }
            ])
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: {
            title: "新增/修改权限组",
            visible: _vm.addNewDialog,
            width: "35%"
          },
          on: {
            "update:visible": function($event) {
              _vm.addNewDialog = $event
            }
          }
        },
        [
          _c(
            "el-form",
            {
              ref: "saveForm",
              attrs: {
                model: _vm.saveForm,
                "label-width": "100px",
                size: "small",
                rules: _vm.rulesForm
              }
            },
            [
              _c(
                "el-form-item",
                { attrs: { label: "管理组名称", prop: "title" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "50%" },
                    model: {
                      value: _vm.saveForm.title,
                      callback: function($$v) {
                        _vm.$set(_vm.saveForm, "title", $$v)
                      },
                      expression: "saveForm.title"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "选择权限", prop: "rules" } },
                [
                  _c("el-tree", {
                    ref: "tree",
                    attrs: {
                      data: _vm.rulesTree,
                      "show-checkbox": "",
                      "node-key": "id",
                      "highlight-current": "",
                      "default-checked-keys": _vm.saveForm.rules,
                      "check-strictly": true
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "状态", prop: "status", required: "" } },
                [
                  _c("el-switch", {
                    attrs: { "active-text": "开启", "inactive-text": "关闭" },
                    model: {
                      value: _vm.saveForm.status,
                      callback: function($$v) {
                        _vm.$set(_vm.saveForm, "status", $$v)
                      },
                      expression: "saveForm.status"
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
                    { attrs: { type: "primary" }, on: { click: _vm.onSubmit } },
                    [_vm._v("保存")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-button",
                    {
                      on: {
                        click: function($event) {
                          _vm.addNewDialog = false
                        }
                      }
                    },
                    [_vm._v("取消")]
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
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
    require("vue-hot-reload-api")      .rerender("data-v-2376835c", module.exports)
  }
}

/***/ })

});