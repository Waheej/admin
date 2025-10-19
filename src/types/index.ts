// ============================================
// Common Types
// ============================================

export interface BaseEntity {
  id: number;
  created_at?: string;
  updated_at?: string;
}

// ============================================
// API Response Types
// ============================================

export interface ApiResponse<T = any> {
  data: T;
  message: string;
  status: boolean;
  meta?: PaginationMeta;
}

export interface ApiError {
  message: string;
  errors?: Record<string, string[]>;
  status: number;
  data?: any;
}

export interface PaginationMeta {
  current_page: number;
  from: number;
  last_page: number;
  per_page: number;
  to: number;
  total: number;
}

// ============================================
// Project Types
// ============================================

export interface Project extends BaseEntity {
  title: string;
  slug: string;
  description: string;
  short_description?: string;
  images: ProjectImage[];
  thumbnail?: string;
  location: string;
  address?: string;
  city?: string;
  country?: string;
  price: number;
  currency: 'SAR' | 'USD' | 'EUR';
  bedrooms?: number;
  bathrooms?: number;
  area: number;
  area_unit?: 'm2' | 'sqft';
  status: ProjectStatus;
  type?: ProjectType;
  amenities?: Amenity[];
  units?: Unit[];
  gallery?: string[];
  video_url?: string;
  brochure_url?: string;
  featured?: boolean;
  seo?: SEO;
}

export type ProjectStatus = 'available' | 'sold-out' | 'coming-soon' | 'under-construction';
export type ProjectType = 'apartment' | 'villa' | 'townhouse' | 'land' | 'commercial' | 'other';

export interface ProjectImage {
  id: number;
  url: string;
  alt?: string;
  caption?: string;
  is_primary?: boolean;
}

export interface Unit extends BaseEntity {
  project_id: number;
  unit_number: string;
  floor?: number;
  bedrooms: number;
  bathrooms: number;
  area: number;
  price: number;
  status: 'available' | 'reserved' | 'sold';
  floor_plan?: string;
}

export interface Amenity {
  id: number;
  name: string;
  icon?: string;
  category?: string;
}

// ============================================
// News/Media Center Types
// ============================================

export interface NewsArticle extends BaseEntity {
  title: string;
  slug: string;
  content: string;
  excerpt?: string;
  featured_image?: string;
  category?: NewsCategory;
  author?: Author;
  published_at: string;
  views?: number;
  tags?: string[];
  seo?: SEO;
}

export interface NewsCategory extends BaseEntity {
  name: string;
  slug: string;
  description?: string;
}

export interface Author {
  id: number;
  name: string;
  avatar?: string;
  bio?: string;
}

// ============================================
// Form Types
// ============================================

export interface ContactFormData {
  name: string;
  email: string;
  mobile: string;
  country_code?: string;
  message: string;
  project_id?: number;
  subject?: string;
}

export interface NewsletterFormData {
  email: string;
}

// ============================================
// SEO Types
// ============================================

export interface SEO {
  title?: string;
  description?: string;
  keywords?: string;
  canonical_url?: string;
  url?: string;
  robots?: string;
  og?: OpenGraph;
  twitter?: TwitterCard;
}

export interface OpenGraph {
  title?: string;
  description?: string;
  image?: string;
  url?: string;
  type?: string;
  site_name?: string;
}

export interface TwitterCard {
  card?: 'summary' | 'summary_large_image' | 'app' | 'player';
  title?: string;
  description?: string;
  image?: string;
  site?: string;
  creator?: string;
}

// ============================================
// UI/Store Types
// ============================================

export interface PopupState {
  component: React.ReactNode | null;
  type: string | null;
}

export interface LoaderState {
  visible: boolean;
  progress: number;
}

export interface MenuState {
  isOpen: boolean;
}

// ============================================
// Utility Types
// ============================================

export type Locale = 'en' | 'ar';

export type AsyncStatus = 'idle' | 'loading' | 'success' | 'error';

export interface SelectOption<T = string> {
  value: T;
  label: string;
  disabled?: boolean;
}

// ============================================
// Component Prop Types
// ============================================

export interface BaseComponentProps {
  className?: string;
  children?: React.ReactNode;
}

export interface ButtonProps extends BaseComponentProps {
  onClick?: () => void;
  disabled?: boolean;
  loading?: boolean;
  type?: 'button' | 'submit' | 'reset';
  variant?: 'primary' | 'secondary' | 'outline' | 'ghost';
  size?: 'sm' | 'md' | 'lg';
}

export interface InputProps {
  name: string;
  label?: string;
  placeholder?: string;
  type?: string;
  value?: string | number;
  onChange?: (value: any) => void;
  error?: string;
  required?: boolean;
  disabled?: boolean;
  className?: string;
}

