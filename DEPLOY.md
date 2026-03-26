# Deploy Fitness App to Railway + Vercel

This guide will help you deploy the Fitness App backend on Railway and frontend on Vercel.

## Quick Links
- [Railway Dashboard](https://railway.app/dashboard)
- [Vercel Dashboard](https://vercel.com/dashboard)

## Architecture
```
┌─────────────┐      ┌─────────────┐      ┌─────────────┐
│   Vercel    │ ───► │   Railway   │ ───► │  Railway    │
│  (Frontend) │      │  (Backend)  │      │   MySQL     │
└─────────────┘      └─────────────┘      └─────────────┘
```

## Step 1: Deploy Backend on Railway

### 1.1 Create Railway Account
1. Go to [railway.app](https://railway.app)
2. Sign up with GitHub
3. Connect your GitHub account

### 1.2 Deploy PHP Backend
1. Click "New Project"
2. Select "Deploy from GitHub repo"
3. Choose your repo
4. Railway will auto-detect PHP and deploy

### 1.3 Add MySQL Database
1. Click "New" → "Database" → "Add MySQL"
2. Wait for it to be ready

### 1.4 Set Environment Variables
In Project Settings → Variables, add:

```
DB_HOST=${{MySQL.RAILWAY_PRIVATE_DOMAIN}}
DB_PORT=3306
DB_USER=${{MYSQL_USER}}
DB_PASS=${{MYSQL_PASSWORD}}
DB_NAME=${{MYSQL_DATABASE}}
APP_ENV=production
APP_DEBUG=false
```

### 1.5 Setup Database
1. Go to MySQL → Connect
2. Open Query Console
3. Copy and run the contents of `database_setup.sql`

### 1.6 Get Your Domain
1. Go to Settings → Domains
2. Click "Generate Domain"
3. Save the URL (e.g., `https://fitness-app-backend.up.railway.app`)

## Step 2: Deploy Frontend on Vercel

### 2.1 Create Vercel Account
1. Go to [vercel.com](https://vercel.com)
2. Sign up with GitHub

### 2.2 Deploy Frontend
1. Click "Add New..." → "Project"
2. Import the same GitHub repo
3. Select Framework Preset: "Other"
4. Root Directory: `php`
5. Click Deploy

### 2.3 Update API URL
1. In Vercel Project Settings, add Environment Variable:
```
API_URL=https://fitness-app-backend.up.railway.app
```

## Step 3: Test Everything

1. Visit your Railway backend URL
2. Visit your Vercel frontend URL
3. Try registering a new user

## Updates

To update after making changes:
```bash
git add .
git commit -m "Update"
git push origin main
```

Both Railway and Vercel will auto-deploy!

## Troubleshooting

### Database Connection Issues
- Check environment variables in Railway
- Verify MySQL is running

### CORS Errors
- Add CORS headers to PHP files
- Check allowed origins

### Assets Not Loading
- Use relative paths instead of absolute paths
