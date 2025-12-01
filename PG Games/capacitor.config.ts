import type { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'com.pggames.app',
  appName: 'PG Games',
  webDir: 'dist',
  server: {
    androidScheme: 'https',
    allowNavigation: ['pgsoft.whitepel.com']
  },
  android: {
    allowMixedContent: true,
    captureInput: true,
    webContentsDebuggingEnabled: false
  },
  plugins: {
    SplashScreen: {
      launchShowDuration: 0
    }
  }
};

export default config;
