@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h1 class="page-title">Dashboard Overview</h1>
        <p style="color: #64748b; margin-top: 0.5rem;">Welcome back to the Cariox Administration Panel.</p>
    </div>

    <!-- Main Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>Total Products</h3>
                <p>{{ $counts['products'] }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <h3>Total Brands</h3>
                <p>{{ $counts['brands'] }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green">
                <i class="fas fa-concierge-bell"></i>
            </div>
            <div class="stat-info">
                <h3>Total Services</h3>
                <p>{{ $counts['services'] }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #fef3c7; color: #d97706;">
                <i class="fas fa-comment-dots"></i>
            </div>
            <div class="stat-info">
                <h3>Testimonials</h3>
                <p>{{ $counts['testimonials'] }}</p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 2rem;">
        <!-- Distribution Details -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">Content Summary</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                <div style="padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                    <span style="font-size: 0.8rem; color: #64748b; display: block; text-transform: uppercase;">Categories</span>
                    <strong style="font-size: 1.5rem; color: #1e293b;">{{ $counts['categories'] }}</strong>
                </div>
                <div style="padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                    <span style="font-size: 0.8rem; color: #64748b; display: block; text-transform: uppercase;">Subcategories</span>
                    <strong style="font-size: 1.5rem; color: #1e293b;">{{ $counts['subcategories'] }}</strong>
                </div>
                <div style="padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                    <span style="font-size: 0.8rem; color: #64748b; display: block; text-transform: uppercase;">Active Blogs</span>
                    <strong style="font-size: 1.5rem; color: #1e293b;">{{ $counts['blogs'] }}</strong>
                </div>
                <div style="padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                    <span style="font-size: 0.8rem; color: #64748b; display: block; text-transform: uppercase;">Form Datas</span>
                    <strong style="font-size: 1.5rem; color: #1e293b;">{{ $counts['form_datas'] }}</strong>
                </div>
                <div style="padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                    <span style="font-size: 0.8rem; color: #64748b; display: block; text-transform: uppercase;">Newsletters</span>
                    <strong style="font-size: 1.5rem; color: #1e293b;">{{ $counts['newsletters'] }}</strong>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">Quick Actions</h2>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('admin.testimonial.create') }}" class="btn-update" style="text-align: center; text-decoration: none;">
                    <i class="fas fa-plus" style="margin-right: 0.5rem;"></i> Add Testimonial
                </a>
                <a href="{{ route('admin.blog.index') }}" class="btn-update" style="text-align: center; text-decoration: none; border-color: #94a3b8; color: #475569;">
                    <i class="fas fa-edit" style="margin-right: 0.5rem;"></i> Write a Blog
                </a>
                <a href="{{ route('admin.settings.info') }}" class="btn-update" style="text-align: center; text-decoration: none; border-color: #94a3b8; color: #475569;">
                    <i class="fas fa-cog" style="margin-right: 0.5rem;"></i> Site Information
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
