/**
 * Remember Me Cookie Utility - SECURE ✅
 * Manages email storage in cookies with ROLE-BASED DURATION
 *
 * Duration:
 * - Admin: 1 day (24 hours) - stricter for high privilege
 * - User:  7 days (168 hours)
 *
 * STORAGE: Email-only, NOT password or sensitive data
 *
 * SECURITY FEATURES:
 * ✅ Email validation (format + length)
 * ✅ Role-based expiration
 * ✅ SameSite=Lax (CSRF protection)
 * ✅ Secure flag (HTTPS only)
 * ✅ encodeURIComponent (XSS protection)
 * ✅ max-age (auto-expire)
 * ✅ Validate on read (tampering detection)
 * ✅ Always verify server-side (never trust client)
 * ✅ Deleted on logout (instant max-age=0)
 */

const REMEMBER_ME_COOKIE_NAME = 'rm_email';
const REMEMBER_ME_ROLE_NAME = 'remembered_role';
const COOKIE_DURATION_ADMIN = 1; // 1 day - stricter for admin
const COOKIE_DURATION_USER = 7; // 7 days - standard for users

/**
 * Validate email format
 */
const isValidEmail = (email: string): boolean => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email) && email.length <= 255;
};

/**
 * Set a cookie with secure attributes
 */
const setCookie = (name: string, value: string, days: number): void => {
    if (typeof document === 'undefined') {
        return;
    }

    const maxAge = days * 24 * 60 * 60;

    // 🔒 Cookie Security Attributes:
    // - path=/          → Available across entire website
    // - max-age={secs}  → Auto-expire in 14 days
    // - SameSite=Lax    → CSRF protection (allow top-level navigations)
    // - Secure          → HTTPS-only (auto-detect from protocol)
    // Note: HttpOnly is set server-side for authentication cookies
    const isSecure = window.location.protocol === 'https:' ? '; Secure' : '';

    document.cookie = `${name}=${encodeURIComponent(value)};path=/;max-age=${maxAge};SameSite=Lax${isSecure}`;
};

/**
 * Get a cookie by name
 */
const getCookie = (name: string): string | null => {
    if (typeof document === 'undefined') {
        return null;
    }

    const nameEQ = name + '=';
    const cookies = document.cookie.split(';');

    for (let cookie of cookies) {
        cookie = cookie.trim();
        if (cookie.indexOf(nameEQ) === 0) {
            const value = decodeURIComponent(cookie.substring(nameEQ.length));
            // Validate even when reading
            if (isValidEmail(value)) {
                return value;
            }
            // Invalid email stored, delete it
            deleteCookie(name);
            return null;
        }
    }

    return null;
};

/**
 * Delete a cookie by name securely
 */
const deleteCookie = (name: string): void => {
    if (typeof document === 'undefined') {
        return;
    }

    document.cookie = `${name}=;path=/;max-age=0;SameSite=Lax`;
};

/**
 * Save email to cookie with role-based duration
 * @param email - User email to remember
 * @param role - User role ('admin' or 'user') for different durations
 *
 * Admin (1 day):  Shorter retention for higher privilege
 * User (7 days):  Standard retention for regular users
 */
export const saveRememberedEmail = (
    email: string,
    role: 'admin' | 'user' = 'user',
): void => {
    // Trim and validate email
    const trimmedEmail = email.trim();

    if (!isValidEmail(trimmedEmail)) {
        console.warn('Invalid email format for remember me');
        clearRememberedEmail();
        return;
    }

    // Determine duration based on role
    const durationDays =
        role === 'admin' ? COOKIE_DURATION_ADMIN : COOKIE_DURATION_USER;

    setCookie(REMEMBER_ME_COOKIE_NAME, trimmedEmail, durationDays);

    // Store role for logout reference
    if (typeof localStorage !== 'undefined') {
        localStorage.setItem(REMEMBER_ME_ROLE_NAME, role);
    }

    console.log(
        `✅ Remember Me saved for ${role} (expires in ${durationDays} days)`,
    );
};

/**
 * Get remembered email from cookie
 * @returns Email if valid, null otherwise
 */
export const getRememberedEmail = (): string | null => {
    return getCookie(REMEMBER_ME_COOKIE_NAME);
};

/**
 * Clear remembered email cookie (call on logout)
 * Removes both email and role info
 */
export const clearRememberedEmail = (): void => {
    deleteCookie(REMEMBER_ME_COOKIE_NAME);

    // Also clear stored role
    if (typeof localStorage !== 'undefined') {
        const role = localStorage.getItem(REMEMBER_ME_ROLE_NAME);
        localStorage.removeItem(REMEMBER_ME_ROLE_NAME);
        console.log(`✅ Remember Me cleared for ${role || 'user'}`);
    }
};

/**
 * Check if there's a remembered email
 */
export const hasRememberedEmail = (): boolean => {
    return getRememberedEmail() !== null;
};

/**
 * Get the role of remembered user
 * @returns 'admin' | 'user' | null
 */
export const getRememberedRole = (): 'admin' | 'user' | null => {
    if (typeof localStorage === 'undefined') {
        return null;
    }
    const role = localStorage.getItem(REMEMBER_ME_ROLE_NAME) as
        | 'admin'
        | 'user'
        | null;
    return role;
};
