# IceMacha E-Commerce Web App - UI/UX Design Specifications

This document contains all the design elements, styles, and specifications used in the IceMacha e-commerce web application.

---

## 🎨 Color Palette

### Brand Colors

| Color Name | Hex Code | Usage | Variable Name |
|------------|----------|-------|---------------|
| **Brand (Primary)** | `#3d6b5a` | Header, primary buttons, accents | `brand` |
| **Cocoa** | `#6b4f4a` | Footer, text color, body text | `cocoa` |
| **Blush** | `#f7e8ec` | Page background | `blush` |
| **Sand** | `#f7d8bd` | Cards, forms, secondary elements | `sand` |
| **Slate** | `#e5e7eb` | Chips, buttons, borders | `slate` |

### Color Variations (Opacity-based)

- **Brand with opacity:**
  - `brand/10` - rgba(61, 107, 90, 0.1) - Subtle backgrounds
  - `brand/20` - rgba(61, 107, 90, 0.2) - Borders
  - `brand/30` - rgba(61, 107, 90, 0.3) - Focus rings
  - `brand/50` - rgba(61, 107, 90, 0.5) - Active borders
  - `brand/70` - rgba(61, 107, 90, 0.7) - Overlays

- **Cocoa with opacity:**
  - `cocoa/10` - rgba(107, 79, 74, 0.1) - Light borders
  - `cocoa/20` - rgba(107, 79, 74, 0.2) - Input borders
  - `cocoa/60` - rgba(107, 79, 74, 0.6) - Secondary text
  - `cocoa/70` - rgba(107, 79, 74, 0.7) - Muted text
  - `cocoa/80` - rgba(107, 79, 74, 0.8) - Labels
  - `cocoa/90` - rgba(107, 79, 74, 0.9) - Emphasized text

- **Sand with opacity:**
  - `sand/40` - hsla(28, 78%, 85%, 0.4) - Subtle backgrounds
  - `sand/90` - hsla(28, 78%, 85%, 0.9) - Semi-opaque backgrounds

- **White with opacity:**
  - `white/10` - hsla(0, 0%, 100%, 0.1) - Subtle overlays
  - `white/15` - hsla(0, 0%, 100%, 0.15) - Borders on dark backgrounds
  - `white/20` - hsla(0, 0%, 100%, 0.2) - Light dividers
  - `white/70` - hsla(0, 0%, 100%, 0.7) - Text on dark backgrounds
  - `white/80` - hsla(0, 0%, 100%, 0.8) - Secondary text on dark

- **Black with opacity:**
  - `black/5` - rgba(0, 0, 0, 0.05) - Subtle shadows
  - `black/30` - rgba(0, 0, 0, 0.3) - Image overlays
  - `black/40` - rgba(0, 0, 0, 0.4) - Carousel overlays
  - `black/60` - rgba(0, 0, 0, 0.6) - Hover states on overlays

### Status & Feedback Colors

| Purpose | Color | Notes |
|---------|-------|-------|
| Success | `green-700` (#15803d) | Success messages |
| Success Background | `green-50` (#f0fdf4) | Success backgrounds |
| Error Text | `red-600` (#dc2626) | Error messages |
| Error Strong | `red-700` (#b91c1c) | Important errors |
| Error Background | `red-50` (#fef2f2) | Error backgrounds |
| Error Border | `red-300` (#fca5a5) | Error input borders |
| Rose Text | `rose-700` (#be123c) | Alternative error |
| Rose Background | `rose-50` (#fff1f2) | Alternative error bg |

### Neutral Colors

| Color | Code | Usage |
|-------|------|-------|
| Gray 50 | `#f9fafb` | Background highlights |
| Gray 100 | `#f3f4f6` | Disabled backgrounds |
| Gray 300 | `#d1d5db` | Borders |
| Gray 400 | `#9ca3af` | Placeholder text |
| Gray 500 | `#6b7280` | Secondary text |
| Gray 600 | `#4b5563` | Body text alternative |
| Gray 700 | `#374151` | Dark text |

---

## 📝 Typography

### Font Family

**Primary Font:**
```css
font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif
```

### Font Sizes & Line Heights

| Size Class | Font Size | Line Height | Usage |
|------------|-----------|-------------|-------|
| `text-xs` | 0.75rem (12px) | 1rem | Small labels, metadata |
| `text-sm` | 0.875rem (14px) | 1.25rem | Secondary text, captions |
| `text-base` | 1rem (16px) | 1.5rem | Body text, inputs |
| `text-[18px]` | 18px | - | Custom sizing |
| `text-lg` | 1.125rem (18px) | 1.75rem | Emphasized text |
| `text-xl` | 1.25rem (20px) | 1.75rem | Section headings |
| `text-[20px]` | 20px | - | Custom heading |
| `text-2xl` | 1.5rem (24px) | 2rem | Page titles (mobile) |
| `text-3xl` | 1.875rem (30px) | 2.25rem | Large headings |
| `text-4xl` | 2.25rem (36px) | 2.5rem | Hero headings |

### Font Weights

| Weight Class | Weight Value | Usage |
|--------------|--------------|-------|
| `font-normal` | 400 | Body text |
| `font-medium` | 500 | Emphasized text |
| `font-semibold` | 600 | Buttons, labels, headings |
| `font-bold` | 700 | Strong headings |
| `font-extrabold` | 800 | Hero text |

### Text Styles

- **Letter Spacing:** `tracking-wide` (0.025em)
- **Line Height (tight):** `leading-tight` (1.25)
- **Line Height (relaxed):** `leading-8` (2rem)
- **Text Truncation:** `truncate`, `line-clamp-1`

---

## 🔲 Border Radius

| Class | Radius | Usage |
|-------|--------|-------|
| `rounded-sm` | 0.125rem (2px) | Small elements |
| `rounded-md` | 0.375rem (6px) | Medium elements |
| `rounded-lg` | 0.5rem (8px) | Logo, images |
| `rounded-xl` | 0.75rem (12px) | Cards, inputs |
| `rounded-2xl` | 1rem (16px) | Major cards, buttons |
| `rounded-3xl` | 1.25rem (20px) | Large containers, forms |
| `rounded-full` | 9999px | Circular elements |

**Custom Border Radius:**
```javascript
borderRadius: { '3xl': '1.25rem' }
```

---

## 🎭 Shadows

### Shadow Utilities

| Class | Shadow Value | Usage |
|-------|--------------|-------|
| `shadow-sm` | `0 1px 2px 0 rgba(0,0,0,0.05)` | Subtle depth |
| `shadow` | `0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1)` | Default cards |
| `shadow-md` | `0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1)` | Elevated cards |
| `shadow-2xl` | `0 25px 50px -12px rgba(0,0,0,0.25)` | Dropdown menus |

### Ring Styles

- **Ring:** `ring-1` with `ring-black/5` - Subtle card borders
- **Ring Brand:** `ring-brand/30` - Focus states

---

## 🎨 Component Styles

### Buttons

#### Primary Button (`.btn-brand`)
```css
padding: 0.5rem 1rem;
border-radius: 1rem;
background-color: #3d6b5a;
color: white;
font-weight: 600;
transition: opacity 0.15s;

&:hover {
  opacity: 0.9;
}
```

#### Ghost Button (`.btn-ghost`)
```css
padding: 0.5rem 1rem;
border-radius: 1rem;
border: 1px solid rgba(107, 79, 74, 0.2);
background-color: white;
color: #6b4f4a;

&:hover {
  background-color: #f7d8bd;
}
```

### Form Elements

#### Input Field (`.input`)
```css
width: 100%;
border-radius: 1rem;
border: 1px solid rgba(107, 79, 74, 0.2);
background-color: white;
padding: 0.75rem 1rem;
font-size: 1rem;
box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);

&:focus {
  border-color: rgba(61, 107, 90, 0.5);
  ring: 2px rgba(61, 107, 90, 0.3);
}
```

#### Textarea (`.textarea`)
```css
width: 100%;
border-radius: 1rem;
border: 1px solid rgba(107, 79, 74, 0.2);
background-color: white;
padding: 0.75rem 1rem;
min-height: 120px;
box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);

&:focus {
  border-color: rgba(61, 107, 90, 0.5);
  ring: 2px rgba(61, 107, 90, 0.3);
}
```

#### Label (`.label`)
```css
font-size: 0.875rem;
font-weight: 600;
color: rgba(107, 79, 74, 0.8);
margin-bottom: 0.25rem;
display: block;
```

### Cards

#### Form Card (`.form-card`)
```css
background-color: white;
border-radius: 1.25rem;
padding: 1.5rem;  /* 2rem on md+ screens */
box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1);
```

#### Admin Cards
```css
background-color: white;
border-radius: 1.25rem;
box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
ring: 1px rgba(61, 107, 90, 0.3);
border: 1px solid rgba(61, 107, 90, 0.1);
padding: 1rem;
```

#### Badge (`.badge`)
```css
display: inline-block;
border-radius: 1rem;
background-color: white;
padding: 0.25rem 0.75rem;
font-weight: 600;
color: #6b4f4a;
```

### Navigation

#### Nav Link (`.nav-link`)
```css
font-weight: 600;

&:hover {
  text-decoration: underline;
}
```

#### Profile Dropdown (`.popover-card`)
```css
position: absolute;
right: 0;
top: 100%;
margin-top: 0.75rem;
width: 18rem;
background-color: white;
color: #6b4f4a;
border-radius: 1rem;
box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
ring: 1px rgba(0, 0, 0, 0.05);
padding: 1rem;
z-index: 50;
```

#### Dropdown Arrow (`.popover-arrow`)
```css
position: absolute;
top: -0.5rem;
right: 2rem;
height: 1rem;
width: 1rem;
background-color: white;
border: 1px solid rgba(0, 0, 0, 0.05);
transform: rotate(45deg);
border-radius: 0.125rem;
```

### Page Layout

#### Page Title (`.page-title`)
```css
text-align: center;
font-size: 1.5rem;  /* 2.25rem on md+ */
font-weight: 700;
color: #3d6b5a;
```

#### Section (`.section`)
```css
margin: 0 auto;
width: 100%;
max-width: 72rem;
padding: 1.5rem 1rem;  /* 2.5rem vertical on md+ */
```

### Hero Section

#### Hero Container (`.hero`)
```css
position: relative;
width: 100%;
overflow: hidden;
```

#### Hero Image (`.hero-img`)
```css
position: absolute;
inset: 0;
width: 100%;
height: 100%;
object-fit: cover;
```

#### Hero Overlay (`.hero-overlay`)
```css
position: absolute;
inset: 0;
background-color: rgba(0, 0, 0, 0.3);
display: flex;
align-items: center;
justify-content: center;
```

#### Hero Content (`.hero-content`)
```css
position: relative;
z-index: 10;
text-align: center;
color: white;
padding: 0 1rem;
```

---

## 🎪 Animations & Transitions

### Carousel Animations

#### Slide Transition (`.promo-slide`)
```css
position: absolute;
inset: 0;
transition: opacity 0.7s;
```

**JavaScript Animation:**
- **Auto-advance interval:** 5000ms (5 seconds)
- **Opacity transition:** 700ms duration
- **States:** `opacity-0` → `opacity-100`
- **Pause on:** Mouse hover, touch interaction

#### Carousel Caption (`.promo-caption`)
```css
position: absolute;
bottom: 0;
left: 0;
right: 0;
background-color: rgba(0, 0, 0, 0.4);
padding: 1rem;
color: white;
display: flex;
justify-content: space-between;
align-items: center;
```

#### Navigation Buttons (`.promo-nav`)
```css
position: absolute;
top: 50%;
transform: translateY(-50%);
border-radius: 9999px;
background-color: rgba(0, 0, 0, 0.4);
padding: 0.5rem 0.75rem;
color: white;

&:hover {
  background-color: rgba(0, 0, 0, 0.6);
}
```

#### Carousel Dots (`.promo-dot`)
```css
height: 0.625rem;
width: 0.625rem;
border-radius: 9999px;

/* Active */
.promo-dot-active {
  background-color: #3d6b5a;
}

/* Inactive */
.promo-dot-inactive {
  background-color: #e5e7eb;
}
```

### Collapse Animation (`.card-collapse`)
```css
overflow: hidden;
max-height: 0;
transition: max-height 0.3s ease;

&.expanded {
  max-height: 1200px;
}
```

#### Collapse Padding (`.card-collapse-pad`)
```css
padding: 0;
transition: padding 0.25s ease;

.card-collapse.expanded & {
  padding: 1rem;  /* 1.5rem on md+ */
}
```

### Hover Effects

#### Link Transitions
```css
transition: color, background-color, opacity 0.15s;

&:hover {
  /* Various hover states */
  opacity: 0.9;
  background-color: rgba(61, 107, 90, 0.1);
  color: #f7d8bd;
}
```

#### Icon Opacity
```css
opacity: 0.8;

&:hover {
  opacity: 1;
}
```

### Mobile Menu Toggle
- **Animation:** Toggle `hidden` class (instant show/hide)
- **Slide-down effect:** CSS transition on display

---

## 📱 Responsive Breakpoints

| Breakpoint | Min Width | Usage |
|------------|-----------|-------|
| `sm` | 640px | Small tablets |
| `md` | 768px | Tablets |
| `lg` | 1024px | Desktops |

### Responsive Patterns

#### Desktop/Mobile Navigation
- **Desktop:** Horizontal nav with centered logo (visible at `md:flex`)
- **Mobile:** Hamburger menu with slide-down drawer (visible below `md`)

#### Grid Layouts
- **1 column** (mobile) → **2-3 columns** (sm) → **5-12 columns** (md/lg)

#### Typography Scaling
- Hero: `text-2xl` → `text-3xl` (sm) → `text-4xl` (md)
- Page Title: `text-2xl` (md) → `text-4xl` (md)

#### Spacing Adjustments
- Section padding: `py-6` → `py-10` (md)
- Card padding: `p-6` → `p-8` (md)

---

## 🎯 Design Patterns & Templates

### Header Template
- **Background:** `bg-brand` with `text-white`
- **Logo:** Centered between navigation groups (desktop), left-aligned (mobile)
- **Icons:** Cart and user profile (6×6 size), hover color: `sand`
- **Profile dropdown:** Appears below icon with arrow pointer

### Footer Template
- **Background:** `bg-cocoa` with `text-white/80`
- **Layout:** Multi-column with links, social icons
- **Social icons:** 6×6 size with `opacity-80`, hover to `opacity-100`
- **Bottom:** Copyright and legal links

### Product Card
```css
background: white;
border-radius: 0.75rem;
padding: 0.5rem;
box-shadow: 0 1px 2px rgba(0,0,0,0.05);
border: 1px solid rgba(107, 79, 74, 0.1);
```

### Checkout Summary
```css
background: #3d6b5a (brand);
color: white;
border-radius: 1rem;
padding: 1rem;
box-shadow: 0 1px 2px rgba(0,0,0,0.05);
```

---

## 🖼️ Image Styles

### Object Fit
- **Cover:** `object-cover` - Hero images, product images
- **Responsive:** `max-width: 100%`, `height: auto`

### Loading Strategy
- **Eager:** Hero images, logo, first carousel slide
- **Lazy:** Secondary images, carousel slides (index > 0)

### Image Sizing Patterns
- **Logo:** `h-9 w-auto`
- **Icons:** `w-6 h-6`
- **Product Images:** Responsive sizing (e.g., `w-20 h-20` → `w-24 h-24` sm → `w-32 h-32` md)
- **Hero:** Full viewport with defined heights (`h-[220px]` → `h-[300px]` sm → `h-[380px]` md)

---

## 🎨 Special Effects

### Overlays
- **Dark overlay:** `bg-black/30` or `bg-black/40`
- **Usage:** Hero sections, carousel captions

### Glassmorphism
- **Elements:** Admin top links bar
- **Style:** `bg-sand/90` with `shadow-sm` and `ring-1 ring-black/5`

### Rotation
- **Arrow/Pointer:** `rotate-45` for dropdown arrows

### Opacity States
- **Default:** `opacity-80` or `opacity-95`
- **Hover:** `opacity-100`
- **Hidden:** `opacity-0`
- **Visible:** `opacity-100`

### Pointer Events
- **Disabled:** `pointer-events-none` on hidden carousel slides

---

## 📐 Spacing System

### Padding Scale
- `p-2` - 0.5rem (8px)
- `p-3` - 0.75rem (12px)
- `p-4` - 1rem (16px)
- `p-6` - 1.5rem (24px)
- `p-8` - 2rem (32px)

### Margin Scale
- `mb-1` - 0.25rem (4px)
- `mb-2` - 0.5rem (8px)
- `mb-4` - 1rem (16px)
- `mb-6` - 1.5rem (24px)
- `mb-8` - 2rem (32px)
- `mt-10` - 2.5rem (40px)

### Gap Scale (Flexbox/Grid)
- `gap-2` - 0.5rem
- `gap-3` - 0.75rem
- `gap-4` - 1rem
- `gap-5` - 1.25rem
- `gap-6` - 1.5rem
- `gap-8` - 2rem

---

## 🎭 Interactive States

### Focus States
```css
outline: 2px solid transparent;
outline-offset: 2px;

&:focus {
  border-color: rgba(61, 107, 90, 0.5);
  ring: 2px rgba(61, 107, 90, 0.3);
}
```

### Hover States
- **Links:** Underline, color change to `brand` or `sand`
- **Buttons:** Opacity to 0.9, background color change
- **Icons:** Opacity to 1.0
- **Cards:** Background color to `gray-50` or `red-50`

### Active/Selected States
- **Carousel dots:** `bg-brand` (active) vs `bg-sage` (inactive)
- **Form inputs:** Focus ring with `brand/30`

### Disabled States
- **Background:** `bg-gray-100`
- **Cursor:** `cursor-default`

---

## 🌐 Accessibility Features

### ARIA Attributes
- `aria-label` on icon buttons
- `aria-haspopup` and `aria-expanded` on dropdown triggers
- `aria-controls` to link triggers and menus

### Screen Reader
- `.sr-only` class for screen-reader-only content

### Semantic HTML
- Proper heading hierarchy
- Semantic tags (`<nav>`, `<main>`, `<section>`, `<header>`)

---

## 📦 Max-Width Containers

| Class | Max Width | Usage |
|-------|-----------|-------|
| `max-w-lg` | 32rem | Small forms |
| `max-w-2xl` | 42rem | Medium content |
| `max-w-3xl` | 48rem | Content blocks |
| `max-w-4xl` | 56rem | Large content |
| `max-w-5xl` | 64rem | Carousel container |
| `max-w-6xl` | 72rem | Main sections, navigation |
| `max-w-7xl` | 80rem | Wide layouts |

---

## 🔧 Tailwind Configuration

```javascript
module.exports = {
  content: ["./app/Views/**/*.php", "./public/**/*.php"],
  theme: {
    extend: {
      colors: {
        brand: "#3d6b5a",
        cocoa: "#6b4f4a",
        blush: "#f7e8ec",
        sand: "#f7d8bd",
        slate: "#e5e7eb"
      },
      fontFamily: { 
        display: ['Poppins', 'ui-sans-serif'] 
      },
      borderRadius: { 
        '3xl': '1.25rem' 
      }
    }
  },
  plugins: []
}
```

---

## 📋 Summary

### Design Philosophy
- **Warm & Inviting:** Earth-tone color palette (greens, browns, beiges)
- **Modern & Clean:** Generous white space, rounded corners, soft shadows
- **Responsive:** Mobile-first approach with thoughtful breakpoints
- **Accessible:** Focus states, ARIA labels, semantic HTML
- **Performance:** Lazy loading, optimized animations

### Key Visual Characteristics
1. **Rounded aesthetic** - Border radius from 0.5rem to 1.25rem
2. **Soft shadows** - Subtle depth with shadow-sm to shadow-2xl
3. **Opacity-based variations** - Consistent color system with transparency
4. **Smooth transitions** - 0.15s to 0.7s duration for interactions
5. **Premium feel** - Glassmorphism, overlays, careful spacing
