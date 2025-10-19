import * as Yup from "yup";
import { VALIDATION } from "./constants";

/**
 * Contact form validation schema
 */
export const contactFormSchema = Yup.object().shape({
  name: Yup.string()
    .min(VALIDATION.NAME.MIN_LENGTH, "Name is too short")
    .max(VALIDATION.NAME.MAX_LENGTH, "Name is too long")
    .required("Name is required"),
  
  email: Yup.string()
    .email("Invalid email address")
    .required("Email is required"),
  
  mobile: Yup.string()
    .matches(VALIDATION.PHONE.PATTERN, "Invalid phone number")
    .required("Phone number is required"),
  
  country_code: Yup.string(),
  
  message: Yup.string()
    .min(VALIDATION.MESSAGE.MIN_LENGTH, `Message must be at least ${VALIDATION.MESSAGE.MIN_LENGTH} characters`)
    .max(VALIDATION.MESSAGE.MAX_LENGTH, `Message must be less than ${VALIDATION.MESSAGE.MAX_LENGTH} characters`)
    .required("Message is required"),
  
  project_id: Yup.number().optional(),
});

/**
 * Newsletter subscription validation schema
 */
export const newsletterSchema = Yup.object().shape({
  email: Yup.string()
    .email("Invalid email address")
    .required("Email is required"),
});

/**
 * Search form validation schema
 */
export const searchSchema = Yup.object().shape({
  query: Yup.string()
    .min(2, "Search query is too short")
    .max(100, "Search query is too long")
    .required("Search query is required"),
  
  category: Yup.string().optional(),
  
  location: Yup.string().optional(),
});

/**
 * Filter form validation schema
 */
export const filterSchema = Yup.object().shape({
  status: Yup.string()
    .oneOf(['available', 'sold-out', 'coming-soon', 'under-construction'])
    .optional(),
  
  type: Yup.string()
    .oneOf(['apartment', 'villa', 'townhouse', 'land', 'commercial'])
    .optional(),
  
  min_price: Yup.number()
    .min(0, "Minimum price cannot be negative")
    .optional(),
  
  max_price: Yup.number()
    .min(0, "Maximum price cannot be negative")
    .when('min_price', (minPrice, schema) => {
      if (minPrice[0]) {
        return schema.min(minPrice[0], "Maximum price must be greater than minimum price");
      }
      return schema;
    })
    .optional(),
  
  bedrooms: Yup.number()
    .min(0, "Bedrooms cannot be negative")
    .max(20, "Bedrooms must be less than 20")
    .optional(),
  
  min_area: Yup.number()
    .min(0, "Minimum area cannot be negative")
    .optional(),
  
  max_area: Yup.number()
    .min(0, "Maximum area cannot be negative")
    .when('min_area', (minArea, schema) => {
      if (minArea[0]) {
        return schema.min(minArea[0], "Maximum area must be greater than minimum area");
      }
      return schema;
    })
    .optional(),
  
  location: Yup.string().optional(),
});

/**
 * Login form validation schema (if needed in future)
 */
export const loginSchema = Yup.object().shape({
  email: Yup.string()
    .email("Invalid email address")
    .required("Email is required"),
  
  password: Yup.string()
    .min(8, "Password must be at least 8 characters")
    .required("Password is required"),
});

/**
 * Register form validation schema (if needed in future)
 */
export const registerSchema = Yup.object().shape({
  name: Yup.string()
    .min(VALIDATION.NAME.MIN_LENGTH, "Name is too short")
    .max(VALIDATION.NAME.MAX_LENGTH, "Name is too long")
    .required("Name is required"),
  
  email: Yup.string()
    .email("Invalid email address")
    .required("Email is required"),
  
  phone: Yup.string()
    .matches(VALIDATION.PHONE.PATTERN, "Invalid phone number")
    .required("Phone number is required"),
  
  password: Yup.string()
    .min(8, "Password must be at least 8 characters")
    .matches(
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/,
      "Password must contain at least one uppercase letter, one lowercase letter, and one number"
    )
    .required("Password is required"),
  
  confirmPassword: Yup.string()
    .oneOf([Yup.ref('password')], "Passwords must match")
    .required("Please confirm your password"),
  
  acceptTerms: Yup.boolean()
    .oneOf([true], "You must accept the terms and conditions")
    .required("You must accept the terms and conditions"),
});

/**
 * Validate a single field
 */
export async function validateField(
  schema: Yup.AnyObjectSchema,
  fieldName: string,
  value: any
): Promise<string | null> {
  try {
    await schema.validateAt(fieldName, { [fieldName]: value });
    return null;
  } catch (error) {
    if (error instanceof Yup.ValidationError) {
      return error.message;
    }
    return "Validation error";
  }
}

/**
 * Validate entire form
 */
export async function validateForm(
  schema: Yup.AnyObjectSchema,
  values: any
): Promise<Record<string, string> | null> {
  try {
    await schema.validate(values, { abortEarly: false });
    return null;
  } catch (error) {
    if (error instanceof Yup.ValidationError) {
      const errors: Record<string, string> = {};
      error.inner.forEach((err) => {
        if (err.path) {
          errors[err.path] = err.message;
        }
      });
      return errors;
    }
    return { _error: "Validation error" };
  }
}

/**
 * Custom validation: Check if file size is within limit
 */
export function validateFileSize(
  file: File,
  maxSizeInBytes: number
): boolean {
  return file.size <= maxSizeInBytes;
}

/**
 * Custom validation: Check if file type is allowed
 */
export function validateFileType(
  file: File,
  allowedTypes: string[]
): boolean {
  return allowedTypes.includes(file.type);
}

/**
 * Custom validation: Check if URL is valid
 */
export function validateUrl(url: string): boolean {
  try {
    new URL(url);
    return true;
  } catch {
    return false;
  }
}

/**
 * Custom validation: Check if Saudi phone number is valid
 */
export function validateSaudiPhone(phone: string): boolean {
  // Saudi phone numbers: +966 followed by 9 digits
  // or 05 followed by 8 digits
  const saudiPhoneRegex = /^(?:\+966|966|0)?5[0-9]{8}$/;
  return saudiPhoneRegex.test(phone.replace(/\s/g, ''));
}

/**
 * Custom validation: Check password strength
 */
export function validatePasswordStrength(password: string): {
  isStrong: boolean;
  score: number;
  feedback: string[];
} {
  const feedback: string[] = [];
  let score = 0;

  if (password.length >= 8) score++;
  else feedback.push("Password should be at least 8 characters");

  if (password.length >= 12) score++;

  if (/[a-z]/.test(password)) score++;
  else feedback.push("Include lowercase letters");

  if (/[A-Z]/.test(password)) score++;
  else feedback.push("Include uppercase letters");

  if (/\d/.test(password)) score++;
  else feedback.push("Include numbers");

  if (/[^A-Za-z0-9]/.test(password)) score++;
  else feedback.push("Include special characters");

  return {
    isStrong: score >= 4,
    score,
    feedback,
  };
}

/**
 * Sanitize input to prevent XSS
 */
export function sanitizeInput(input: string): string {
  return input
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#x27;')
    .replace(/\//g, '&#x2F;');
}

/**
 * Validate Arabic text
 */
export function isArabicText(text: string): boolean {
  const arabicRegex = /[\u0600-\u06FF]/;
  return arabicRegex.test(text);
}

/**
 * Validate English text
 */
export function isEnglishText(text: string): boolean {
  const englishRegex = /^[A-Za-z\s]+$/;
  return englishRegex.test(text);
}

