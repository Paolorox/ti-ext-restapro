<div class="container-fluid py-4" style="background-color: #f8f9fa;">
    <style>
        .timeline {
            position: relative;
            padding: 2rem 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 2rem;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #3b82f6, #8b5cf6);
            border-radius: 4px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
            padding-left: 5rem;
        }
        .timeline-icon {
            position: absolute;
            left: 1.25rem;
            top: 0;
            width: 1.8rem;
            height: 1.8rem;
            border-radius: 50%;
            background: #fff;
            border: 4px solid #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .timeline-content {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
        }
        .timeline-content:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .timeline-date {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .version-badge {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
        }
    </style>

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-1" style="color: #1e293b; letter-spacing: -0.5px;">RestaPro Updates & Changelog</h2>
            <p class="text-muted">Discover the latest features, improvements, and fixes.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-lg-8 mx-auto">
            <div class="timeline">
                
                <!-- Version 1.1.0 -->
                <div class="timeline-item">
                    <div class="timeline-icon" style="border-color: #8b5cf6;"></div>
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="version-badge" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">v1.1.0</span>
                            </div>
                            <span class="timeline-date">July 11, 2026</span>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">UI Refactoring & Architecture Enhancements</h4>
                        <ul class="text-muted" style="line-height: 1.8; list-style-type: square; padding-left: 1.5rem;">
                            <li><strong>Refactored Dashboard UI:</strong> Migrated to a glassmorphism design system using Inter typography and CSS micro-animations.</li>
                            <li><strong>Relationship Mapping:</strong> Implemented active recipe querying within the Ingredient model to display relational usage history.</li>
                            <li><strong>Module Integration:</strong> Integrated Purchase Orders resource directly into the Supplier interface for unified data retrieval.</li>
                            <li><strong>Calculated Attributes:</strong> Added dynamic real-time profit margin computation based on target food cost constraints.</li>
                            <li><strong>Bug Fixes:</strong> Patched Stock Movement timestamp recording and resolved a reflection exception related to controller class naming.</li>
                        </ul>
                    </div>
                </div>

                <!-- Version 1.0.0 -->
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="version-badge">v1.0.0</span>
                            <span class="timeline-date">July 10, 2026</span>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Initial Release: Core Modules</h4>
                        <ul class="text-muted" style="line-height: 1.8; list-style-type: square; padding-left: 1.5rem;">
                            <li><strong>Core Architecture:</strong> Bootstrapped base entities for Ingredients, Recipes, Suppliers, and Purchase Orders.</li>
                            <li><strong>Event Listeners:</strong> Configured auto-deduction routines hooking into TastyIgniter core order events.</li>
                            <li><strong>Yield Computation:</strong> Implemented formulas to process yield percentages and adjust theoretical costs.</li>
                            <li><strong>Alert System:</strong> Developed threshold-based logic for low stock and expiration date notifications.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
