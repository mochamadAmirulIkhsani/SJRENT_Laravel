# Phase 6: Admin Panel Quick Test Guide

## 🔐 Login to Admin Panel

1. Open browser: http://127.0.0.1:8000/admin/login
2. Login with your admin credentials

---

## ✅ Testing Checklist

### 1. Company Settings (Singleton Resource)

**URL:** http://127.0.0.1:8000/admin/company-settings

**Test Steps:**
- [ ] Should redirect directly to edit page (no list page)
- [ ] Check all 7 tabs are visible:
  - [ ] Company Information
  - [ ] Contact Details
  - [ ] Business Hours
  - [ ] Social Media
  - [ ] SEO Settings
  - [ ] Why Choose Us
  - [ ] FAQs
- [ ] Try uploading a logo (max 2MB)
- [ ] Try uploading a favicon (max 1MB)
- [ ] Fill in some FAQs using the repeater
- [ ] Add business hours (Senin-Minggu)
- [ ] Add social media links (KeyValue)
- [ ] Save and check for success notification
- [ ] Refresh - data should persist

**Expected:** All fields save correctly, no errors

---

### 2. Testimonials Resource

**URL:** http://127.0.0.1:8000/admin/testimonials

**Test Steps:**
- [ ] Click "Create" to add new testimonial
- [ ] Fill in customer name (e.g., "John Doe")
- [ ] Upload a customer photo (optional)
- [ ] Select rating (5 stars)
- [ ] Write review text
- [ ] Set display_order to 1
- [ ] Save without approving (is_approved = false)
- [ ] Check navigation badge - should show "1" pending
- [ ] Go back to list
- [ ] Toggle the approval column - should turn on
- [ ] Badge should disappear
- [ ] Try drag & drop to reorder (if you have 2+ testimonials)
- [ ] Test filters: Approval Status, Rating
- [ ] Test bulk actions: Select multiple, bulk approve

**Expected:** 
- Badge shows pending count
- Toggle works inline
- Reordering works
- Filters work
- Bulk actions work

---

### 3. Gallery Resource

**URL:** http://127.0.0.1:8000/admin/galleries

**Test Steps:**
- [ ] Click "Create" to add new image
- [ ] Upload an image (max 2MB)
- [ ] Try the image editor (crop, rotate)
- [ ] Select category (Company/Fleet/Facilities)
- [ ] Add title (e.g., "Office Exterior")
- [ ] Add alt text (e.g., "SJRent office building")
- [ ] Set display_order to 1
- [ ] Save
- [ ] Check table - image should appear with badge color:
  - Company = Blue
  - Fleet = Green
  - Facilities = Yellow
- [ ] Try category filter
- [ ] Try drag & drop reordering
- [ ] Test bulk action: Change category

**Expected:**
- Image uploads successfully
- Category badges show correct colors
- Filters work
- Reordering works
- Image editor works

---

### 4. Motorcycles Resource (Enhanced)

**URL:** http://127.0.0.1:8000/admin/motorcycles

**Test Steps:**
- [ ] Open an existing motorcycle (or create new)
- [ ] Check that slug field exists
- [ ] On create: Type name, check if slug auto-fills
- [ ] Go to "Features & Specs" tab
- [ ] Add features using TagsInput (e.g., "ABS, USB Charger, Large Storage")
- [ ] Add specifications using KeyValue:
  - Engine Capacity → 125cc
  - Transmission → Automatic
  - Seat Capacity → 2 persons
- [ ] Go to "SEO" tab
- [ ] Fill SEO title (max 60 chars)
- [ ] Fill SEO description (max 160 chars)
- [ ] Save
- [ ] Go back to list
- [ ] Toggle slug column visibility (should be hidden by default)
- [ ] Click slug - should be copyable

**Expected:**
- New tabs appear (Features & Specs, SEO)
- Slug auto-generates
- TagsInput works for features
- KeyValue works for specs
- Slug is copyable from table

---

### 5. Preview Website Button

**Location:** Sidebar → Konten Website → Preview Website

**Test Steps:**
- [ ] Look for "Preview Website" in sidebar under "Konten Website" group
- [ ] Click it
- [ ] Should open public homepage in new tab
- [ ] URL should be: http://127.0.0.1:8000/

**Expected:** Opens public site in new tab

---

### 6. Navigation Structure

**Test Steps:**
- [ ] Check navigation groups exist:
  - [ ] Master Data (Categories, Customers, Motorcycles)
  - [ ] Operasional (Rentals, Rental Payments)
  - [ ] Konten Website (Preview, Testimonials, Gallery)
  - [ ] Pengaturan (Company Settings)
  - [ ] Laporan (collapsed by default)
- [ ] Check icons display correctly
- [ ] Check badge on Testimonials (pending count)

**Expected:** All groups appear in correct order with proper items

---

## 🐛 Common Issues & Solutions

### Issue: "Type error in CompanySettingResource"
**Solution:** Already fixed - navigationGroup has proper type hint

### Issue: "Slug column not showing"
**Solution:** It's hidden by default - toggle it visible from table column selector

### Issue: "Cannot upload images"
**Solution:** Make sure storage is linked: `php artisan storage:link`

### Issue: "Repeater fields not saving"
**Solution:** Check database - JSON fields should be cast as 'array' in model

### Issue: "Navigation badge not showing"
**Solution:** Make sure you have pending testimonials (is_approved = false)

---

## 📊 Quick Database Check

Run these to verify data:

```bash
# Check company settings exist
php artisan tinker
>>> App\Models\CompanySetting::first()

# Check testimonials
>>> App\Models\Testimonial::count()

# Check gallery
>>> App\Models\Gallery::count()

# Check motorcycle slug
>>> App\Models\Motorcycle::first()->slug
```

---

## ✅ Success Criteria

Phase 6 is successful if:
- ✅ Company Settings editable (singleton pattern works)
- ✅ Can create/approve testimonials
- ✅ Can upload gallery images with categories
- ✅ Motorcycle has slug, features, specs, SEO fields
- ✅ Preview button opens public site
- ✅ All navigation groups visible
- ✅ No errors when saving any resource
- ✅ Badge shows pending testimonial count
- ✅ Drag & drop reordering works
- ✅ Bulk actions work

---

## 🎯 Test Data Suggestions

### Sample Testimonial:
- Customer: "Budi Santoso"
- Rating: 5 stars
- Review: "Pelayanan sangat memuaskan! Motor selalu dalam kondisi prima dan harga terjangkau."

### Sample Gallery:
- Title: "Honda Beat 2023"
- Category: Fleet
- Alt Text: "Honda Beat motorcycle for rent"

### Sample Motorcycle Features:
- ABS Brakes
- USB Charger
- Large Storage Box
- Digital Speedometer

### Sample Specifications:
- Engine Capacity: 125cc
- Transmission: Automatic (CVT)
- Fuel Type: Pertamax
- Seat Capacity: 2 persons
- Fuel Tank: 4 liters

---

**Happy Testing! 🚀**

If you encounter any issues, check the error logs:
```bash
tail -f storage/logs/laravel.log
```
