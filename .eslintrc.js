// https://eslint.org/docs/user-guide/configuring

module.exports = {
  root: true,
  parserOptions: {
    parser: 'babel-eslint'
  },
  env: {
    browser: true,
    commonjs: true,
    es6: true,
    jquery: true
  },
  globals: {
    moment: true,
    _: true
  },
  extends: [
    // https://github.com/vuejs/eslint-plugin-vue#priority-a-essential-error-prevention
    // consider switching to `plugin:vue/strongly-recommended` or `plugin:vue/recommended` for stricter rules.
    'plugin:vue/recommended',
    // https://github.com/standard/standard/blob/master/docs/RULES-en.md
    'standard'
  ],
  // required to lint *.vue files
  plugins: [
    'vue',
    'babel'
  ],
  // add your custom rules here
  rules: {
    // allow:async-await,
    'generator-star-spacing': 'off',
    // 'indent': ["error", 2, { "MemberExpression": 1 }],
    'newline-per-chained-call': 2,
    // 'newline-per-chained-call': 'off',
    // 'eslint-disable-next-line': 'off',
    //  'handle-callback-err': 'off',
    // 'vue/script-indent': ["error", 2, {"baseIndent": 1}],
    // allow debugger during development
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    // 'template-curly-spacing': 'off'
  }
}
