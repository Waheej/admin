/**
 * Simple logger utility for consistent logging across the application
 */

type LogLevel = 'info' | 'warn' | 'error' | 'debug';

interface LoggerOptions {
  timestamp?: boolean;
  emoji?: boolean;
  context?: string;
}

const EMOJIS = {
  info: 'ℹ️',
  warn: '⚠️',
  error: '❌',
  debug: '🐛',
  success: '✅',
  api: '🌐',
  db: '💾',
  auth: '🔐',
} as const;

class Logger {
  private isDevelopment = process.env.NODE_ENV === 'development';
  
  private formatMessage(
    level: LogLevel,
    message: string,
    data?: any,
    options: LoggerOptions = {}
  ): string {
    const { timestamp = true, emoji = true, context } = options;
    
    let formattedMessage = '';
    
    // Add emoji
    if (emoji && EMOJIS[level]) {
      formattedMessage += `${EMOJIS[level]} `;
    }
    
    // Add timestamp
    if (timestamp) {
      const time = new Date().toISOString();
      formattedMessage += `[${time}] `;
    }
    
    // Add context
    if (context) {
      formattedMessage += `[${context}] `;
    }
    
    // Add level
    formattedMessage += `[${level.toUpperCase()}] `;
    
    // Add message
    formattedMessage += message;
    
    return formattedMessage;
  }

  info(message: string, data?: any, options?: LoggerOptions): void {
    if (!this.isDevelopment) return;
    
    const formatted = this.formatMessage('info', message, data, options);
    console.log(formatted, data || '');
  }

  warn(message: string, data?: any, options?: LoggerOptions): void {
    const formatted = this.formatMessage('warn', message, data, options);
    console.warn(formatted, data || '');
  }

  error(message: string, error?: any, options?: LoggerOptions): void {
    const formatted = this.formatMessage('error', message, error, options);
    console.error(formatted, error || '');
    
    // TODO: Send to error tracking service (Sentry, LogRocket, etc.)
    // if (process.env.NEXT_PUBLIC_SENTRY_DSN) {
    //   Sentry.captureException(error, { extra: { message } });
    // }
  }

  debug(message: string, data?: any, options?: LoggerOptions): void {
    if (!this.isDevelopment) return;
    
    const formatted = this.formatMessage('debug', message, data, options);
    console.debug(formatted, data || '');
  }

  success(message: string, data?: any, options?: LoggerOptions): void {
    if (!this.isDevelopment) return;
    
    console.log(`${EMOJIS.success} ${message}`, data || '');
  }

  api(message: string, data?: any, options?: LoggerOptions): void {
    if (!this.isDevelopment) return;
    
    console.log(`${EMOJIS.api} [API] ${message}`, data || '');
  }

  /**
   * Log API request details
   */
  apiRequest(method: string, url: string, data?: any): void {
    if (!this.isDevelopment) return;
    
    this.api(`Request: ${method} ${url}`, data);
  }

  /**
   * Log API response details
   */
  apiResponse(method: string, url: string, status: number, data?: any): void {
    if (!this.isDevelopment) return;
    
    const emoji = status >= 200 && status < 300 ? EMOJIS.success : EMOJIS.error;
    console.log(`${emoji} [API] Response: ${method} ${url} - ${status}`, data);
  }

  /**
   * Log API error details
   */
  apiError(method: string, url: string, error: any): void {
    this.error(`API Error: ${method} ${url}`, {
      status: error.response?.status,
      message: error.message,
      data: error.response?.data,
    });
  }

  /**
   * Group related logs
   */
  group(label: string, callback: () => void): void {
    if (!this.isDevelopment) return;
    
    console.group(label);
    callback();
    console.groupEnd();
  }

  /**
   * Log performance metrics
   */
  performance(label: string, duration: number): void {
    if (!this.isDevelopment) return;
    
    console.log(`⚡ [PERFORMANCE] ${label}: ${duration.toFixed(2)}ms`);
  }

  /**
   * Start performance measurement
   */
  startPerformance(label: string): () => void {
    const start = performance.now();
    
    return () => {
      const end = performance.now();
      this.performance(label, end - start);
    };
  }
}

// Export singleton instance
export const logger = new Logger();

// Export for advanced usage
export default Logger;

