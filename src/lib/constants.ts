// ============================================
// Site Configuration
// ============================================

export const SITE_CONFIG = {
  name: 'Waheej',
  nameAr: 'وهيج',
  url: process.env.NEXT_PUBLIC_SITE_URL || 'https://waheejsa.com',
  description: 'استثمر واسكن في السعودية: فرص عقارية مميزة',
  descriptionEn: 'Real Estate In Saudi Arabia: idea for living and investing',
} as const;

// ============================================
// API Configuration
// ============================================

export const API_CONFIG = {
  baseURL: process.env.NEXT_PUBLIC_API_URL_STAGING || 'https://admin.waheejsa.com/api/',
  timeout: 30000,
  retryAttempts: 3,
} as const;

// ============================================
// Social Media Links
// ============================================

export const SOCIAL_LINKS = {
  facebook: process.env.NEXT_PUBLIC_FACEBOOK_URL || 'https://facebook.com/waheej',
  twitter: process.env.NEXT_PUBLIC_TWITTER_URL || 'https://twitter.com/waheej',
  instagram: process.env.NEXT_PUBLIC_INSTAGRAM_URL || 'https://instagram.com/waheej',
  linkedin: process.env.NEXT_PUBLIC_LINKEDIN_URL || 'https://linkedin.com/company/waheej',
  tiktok: process.env.NEXT_PUBLIC_TIKTOK_URL || 'https://tiktok.com/@waheej',
  youtube: process.env.NEXT_PUBLIC_YOUTUBE_URL || 'https://youtube.com/@waheej',
} as const;

// ============================================
// Contact Information
// ============================================

export const CONTACT_INFO = {
  phone: process.env.NEXT_PUBLIC_PHONE || '+966XXXXXXXXX',
  email: process.env.NEXT_PUBLIC_EMAIL || 'info@waheejsa.com',
  address: process.env.NEXT_PUBLIC_ADDRESS || 'Riyadh, Saudi Arabia',
  location: {
    city: 'Riyadh',
    country: 'Saudi Arabia',
    coordinates: {
      lat: 24.7136,
      lng: 46.6753,
    },
  },
} as const;

// ============================================
// Navigation Menu Items
// ============================================

export const MENU_ITEMS = [
  { 
    label: 'menu.home', 
    ariaLabel: 'Go to home page', 
    link: '/',
    icon: 'home'
  },
  { 
    label: 'menu.about_us', 
    ariaLabel: 'Learn about us', 
    link: '/about-us',
    icon: 'info'
  },
  { 
    label: 'menu.projects', 
    ariaLabel: 'View our projects', 
    link: '/projects',
    icon: 'building'
  },
  { 
    label: 'menu.media_center', 
    ariaLabel: 'Visit our media center', 
    link: '/media-center',
    icon: 'newspaper'
  },
] as const;

// ============================================
// Project Status
// ============================================

export const PROJECT_STATUS = {
  AVAILABLE: 'available',
  SOLD_OUT: 'sold-out',
  COMING_SOON: 'coming-soon',
  UNDER_CONSTRUCTION: 'under-construction',
} as const;

// ============================================
// Currency
// ============================================

export const CURRENCY = {
  SAR: {
    symbol: 'ر.س',
    code: 'SAR',
    locale: 'ar-SA',
  },
  USD: {
    symbol: '$',
    code: 'USD',
    locale: 'en-US',
  },
  EUR: {
    symbol: '€',
    code: 'EUR',
    locale: 'de-DE',
  },
} as const;

// ============================================
// Date Formats
// ============================================

export const DATE_FORMATS = {
  SHORT: 'DD/MM/YYYY',
  LONG: 'DD MMMM YYYY',
  WITH_TIME: 'DD/MM/YYYY HH:mm',
  ISO: 'YYYY-MM-DD',
} as const;

// ============================================
// Pagination
// ============================================

export const PAGINATION = {
  DEFAULT_PAGE_SIZE: 12,
  PAGE_SIZES: [6, 12, 24, 48],
} as const;

// ============================================
// Animation Durations (in seconds)
// ============================================

export const ANIMATION_DURATION = {
  FAST: 0.3,
  NORMAL: 0.5,
  SLOW: 0.8,
  PAGE_TRANSITION: 1.2,
} as const;

// ============================================
// Breakpoints (matching Tailwind)
// ============================================

export const BREAKPOINTS = {
  SM: 640,
  MD: 768,
  LG: 1024,
  XL: 1280,
  '2XL': 1536,
} as const;

// ============================================
// File Upload Limits
// ============================================

export const UPLOAD_LIMITS = {
  MAX_FILE_SIZE: 5 * 1024 * 1024, // 5MB
  ALLOWED_IMAGE_TYPES: ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
  ALLOWED_DOCUMENT_TYPES: ['application/pdf', 'application/msword'],
} as const;

// ============================================
// Validation Rules
// ============================================

export const VALIDATION = {
  NAME: {
    MIN_LENGTH: 2,
    MAX_LENGTH: 50,
  },
  EMAIL: {
    PATTERN: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
  },
  PHONE: {
    PATTERN: /^[0-9]{9,15}$/,
  },
  MESSAGE: {
    MIN_LENGTH: 20,
    MAX_LENGTH: 500,
  },
} as const;

// ============================================
// Local Storage Keys
// ============================================

export const STORAGE_KEYS = {
  LOCALE: 'waheej_locale',
  THEME: 'waheej_theme',
  FAVORITES: 'waheej_favorites',
  RECENTLY_VIEWED: 'waheej_recently_viewed',
} as const;

// ============================================
// Query Keys (React Query)
// ============================================

export const QUERY_KEYS = {
  HOME_PAGE: 'homePage',
  ABOUT_PAGE: 'aboutPage',
  PROJECTS: 'projects',
  PROJECT_DETAILS: 'projectDetails',
  NEWS: 'news',
  NEWS_DETAILS: 'newsDetails',
  MEDIA_CENTER: 'mediaCenter',
} as const;

// ============================================
// Meta Tags Defaults
// ============================================

export const DEFAULT_META = {
  title: 'وهيج | Waheej - العقارات في السعودية',
  description: 'استثمر واسكن في السعودية: فرص عقارية مميزة',
  keywords: 'عقارات السعودية، استثمار عقاري، شقق للبيع، فلل للبيع، الرياض، جدة',
  ogImage: '/images/logo/logo-rect-light.svg',
  twitterHandle: '@waheej',
} as const;

// ============================================
// Feature Flags
// ============================================

export const FEATURES = {
  ENABLE_PWA: process.env.NEXT_PUBLIC_ENABLE_PWA === 'true',
  ENABLE_ANALYTICS: process.env.NEXT_PUBLIC_ENABLE_ANALYTICS === 'true',
  ENABLE_SEARCH: true,
  ENABLE_FAVORITES: true,
  ENABLE_COMPARISON: true,
  ENABLE_NOTIFICATIONS: false,
} as const;

