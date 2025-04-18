# App Context: Social Media Reels Publisher

## Overview

The goal of this app is to allow users to **publish video reels (short videos)** to multiple social media platforms from a **single interface**. Supported platforms include:
- TikTok
- Instagram (Reels)
- Facebook (Reels)
- YouTube (Shorts)

## Target Users
- Content creators
- Social media managers
- Small businesses and influencers

## Core Features

### 1. Upload Video Content
- User can upload a video file (MP4, MOV)
- Optional: Add a title, caption, hashtags

### 2. Platform Selection
- Let user choose which platforms to publish to (TikTok, Instagram, Facebook, YouTube)
- Allow selecting multiple platforms at once

### 3. Authentication & Authorization
- OAuth login for each platform
- Save tokens securely
- Support multi-account linking

### 4. Post Scheduler (Optional)
- Schedule posts for future publishing
- Display upcoming scheduled posts
- Allow editing or canceling scheduled posts

### 5. Video Editor (Optional MVP+)
- Basic trim, crop, add background music, text overlays
- Export with platform-optimized resolution (9:16)

### 6. Publish & Monitor
- Submit posts through API to each platform
- Show status: success, pending, failed
- Optionally retrieve view count, likes, comments after posting

## Technical Requirements

### Frontend
- React Native or Flutter (for cross-platform mobile)
- File picker, video preview, basic editing tools
- OAuth login for each platform

### Backend
- Node.js or Python (FastAPI/Django) for API server
- Firebase or Supabase for authentication (or custom)
- Database to store user data, tokens, post history

### Platform APIs (Important Notes)
- **TikTok API**: Requires business account and developer access
- **Instagram/Facebook**: Use Meta Graph API
- **YouTube Shorts**: Use YouTube Data API v3
- Must handle video upload, title/description, tags

### Security
- Store OAuth tokens securely (encrypted at rest)
- Validate file types and sizes
- Protect scheduled posts with authentication

## Future Features (Post-MVP)
- Analytics dashboard
- Content calendar
- Hashtag suggestion tool
- AI caption generator

## Notes for Developer
- Make the architecture modular so more platforms can be added later
- Keep UI clean and user-friendly, prioritize ease of use
- Support mobile-first experience, but web version can be added later

---

