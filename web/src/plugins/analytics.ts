import Vue from "vue";
import router from "@/router";
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import VueAnalytics from "vue-ua"

Vue.use(VueAnalytics, {
  appName: 'HD Web',
  appVersion: '0.1.0',
  trackingId: process.env.VUE_APP_TRACKING_ID,
  vueRouter: router,
  trackPage: true,
  debug: true
})

declare module 'vue/types/vue'{
  export interface Vue{
    $analytics: VueUA
    $ua: VueUA
  }

  interface VueUA{
    /**
     * Dispatch an analytics event.
     * Format is the same as analytics classical values.
     * @param category
     * @param action
     * @param label
     * @param value
     */
    trackEvent: (category: string, action: string, label?: string, value?:  number) => void

    /**
     * Dispatch a view using the screen name
     *
     * @param screenName {string}
     * @param trackPage {boolean} - Default is false. Whether you want the dispatched view to be recorded as pageview (website) or screenview (app).
     */
    trackView: (screenName: string, trackPage?: true) => void

    /**
     * Track an user timing to measure periods of time.
     *
     * @param {string} timingCategory - A string for categorizing all user timing variables into logical groups (e.g. 'JS Dependencies').
     * @param {string} timingVar -  A string to identify the variable being recorded (e.g. 'load').
     * @param {number} timingValue - The number of milliseconds in elapsed time to report to Google Analytics (e.g. 20).
     * @param {string|null} timingLabel -  A string that can be used to add flexibility in visualizing user timings in the reports (e.g. 'Google CDN').
     */
    trackTiming: (timingCategory: string, timingVar: string, timingValue: number, timingLabel?: string) => void

    /**
     * Inject a new GlobalDimension that will be sent every time.
     *
     * Prefer inject through plugin configuration.
     *
     * @param {int} dimensionNumber
     * @param {string|int} value
     *
     * @throws Error - If already defined
     */
    injectGlobalDimension: (dimensionNumber: number, value:string | number) => void

    /**
     * Inject a new GlobalMetric that will be sent every time.
     *
     * Prefer inject through plugin configuration.
     *
     * @param {int} metricNumber
     * @param {string|int} value
     *
     * @throws Error - If already defined
     */
    injectGlobalMetric: (metricNumber: number, value: string | number) => void

    /**
     * Track an exception that occurred in the application.
     *
     * @param {string} description - Something describing the error (max. 150 Bytes)
     * @param {boolean} isFatal - Default is false. Specifies whether the exception was fatal
     */
    trackException: (description: string, isFatal?: true) => void

    /**
     * Set the current session language, use this if you change lang in the application after initialization.
     *
     * @param {string} code - Must be like in that : http://www.lingoes.net/en/translator/langcode.htm
     */
    changeSessionLocale: (code:  string) => void
  }
}
