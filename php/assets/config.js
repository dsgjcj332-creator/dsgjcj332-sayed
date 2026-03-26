const CONFIG = {
  // API Base URL - change this to your Railway backend URL after deployment
  API_URL: window.location.hostname === 'localhost' 
    ? 'http://localhost/fitness' 
    : 'https://fitness-app-backend.up.railway.app',
  
  // App settings
  APP_NAME: 'مدرب اللياقة الذكي',
  APP_VERSION: '1.0.0',
  
  // Feature flags
  ENABLE_AI_RECOMMENDATIONS: true,
  ENABLE_VIDEO_TUTORIALS: true,
  ENABLE_PROGRESS_TRACKING: true
};

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
  module.exports = CONFIG;
}
