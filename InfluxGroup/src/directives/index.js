import { createApp } from 'vue'
import vScrollAnimate from './vScrollAnimate.js'
import vLazyLoad from './vLazyLoad.js'
import vCounter from './vCounter.js'

export function registerDirectives(app) {
  app.directive('scroll-animate', vScrollAnimate)
  app.directive('lazy-load', vLazyLoad)
  app.directive('counter', vCounter)
}

export {
  vScrollAnimate,
  vLazyLoad,
  vCounter
}
