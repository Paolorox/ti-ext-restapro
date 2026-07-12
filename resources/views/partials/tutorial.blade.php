<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css"/>
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof window.driver === 'undefined') return;

    const tourCompleted = localStorage.getItem('restapro_tour_completed');
    if (!tourCompleted) {
        // Segna immediatamente il tutorial come completato così non si riapre mai più
        localStorage.setItem('restapro_tour_completed', 'true');

        // Forcefully open the RestaPro sidebar menu by finding one of its children
        const dashboardLink = document.querySelector('#side-nav-menu a[href*="restapro/dashboard"]');
        if (dashboardLink) {
            // Find the parent UL (the submenu container)
            const parentUl = dashboardLink.closest('ul');
            if (parentUl && parentUl.id !== 'side-nav-menu') {
                // Remove collapse classes or force display
                parentUl.classList.add('show', 'in');
                parentUl.style.display = 'block';
                parentUl.style.height = 'auto';
                
                // Find the parent LI (the main menu item) to click it if needed
                const parentLi = parentUl.closest('li');
                if (parentLi) {
                    parentLi.classList.add('active', 'menu-open');
                    const toggleLink = parentLi.querySelector('a');
                    if (toggleLink && toggleLink.getAttribute('aria-expanded') === 'false') {
                        toggleLink.click();
                    }
                }
            }
        }

        // We use a specific selector for the sidebar to avoid matching hidden mobile menus
        const buildSelector = (href) => {
            return `#side-nav-menu a[href*="${href}"]`;
        };

        const driverObj = window.driver.js.driver({
            showProgress: true,
            animate: true,
            allowClose: false,
            doneBtnText: 'Finish',
            nextBtnText: 'Next',
            prevBtnText: 'Previous',
            steps: [
                {
                    popover: {
                        title: 'Welcome to RestaPro!',
                        description: 'This quick guided tour will show you how to navigate your new advanced food cost and inventory system. Let\'s get started.',
                        align: 'center'
                    }
                },
                {
                    element: buildSelector('restapro/dashboard'),
                    popover: {
                        title: 'Dashboard',
                        description: 'Your control center. View critical alerts, low stock items, and overall inventory value at a glance.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: buildSelector('restapro/ingredients'),
                    popover: {
                        title: 'Ingredients',
                        description: 'Manage all your raw materials here. You can set minimum stock levels, unit costs, and import them via CSV.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: buildSelector('restapro/recipes'),
                    popover: {
                        title: 'Recipes (Bill of Materials)',
                        description: 'Combine ingredients to create recipes. The system will automatically calculate your exact food cost and profit margins.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: buildSelector('restapro/stockmovements'),
                    popover: {
                        title: 'Stock Movements & Waste',
                        description: 'Manually add stock, record waste, or perform inventory adjustments here.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: buildSelector('restapro/purchaseorders'),
                    popover: {
                        title: 'Purchase Orders',
                        description: 'Generate POs for your suppliers automatically when ingredients run below their minimum threshold.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    popover: {
                        title: 'You\'re all set!',
                        description: 'Don\'t forget to visit System > Settings > RestaPro Settings to configure your Units and Categories before starting.',
                        align: 'center'
                    }
                }
            ]
        });

        // Longer delay to ensure the DOM and sidebar are fully rendered and expanded
        setTimeout(() => {
            driverObj.drive();
        }, 1200);
    }
});
</script>
