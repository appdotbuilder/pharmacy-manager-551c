import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="PharmaCare Pro - Complete Pharmacy Management">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
                {/* Header */}
                <header className="w-full px-6 py-4">
                    <nav className="flex items-center justify-between max-w-7xl mx-auto">
                        <div className="flex items-center space-x-3">
                            <div className="w-10 h-10 bg-gradient-to-r from-blue-600 to-green-600 rounded-lg flex items-center justify-center">
                                <span className="text-white font-bold text-xl">🏥</span>
                            </div>
                            <h1 className="text-2xl font-bold text-gray-900 dark:text-white">PharmaCare Pro</h1>
                        </div>
                        <div className="flex items-center space-x-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="text-gray-700 dark:text-gray-300 hover:text-blue-600 px-4 py-2 rounded-lg transition-colors"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                                    >
                                        Get Started
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                {/* Hero Section */}
                <main className="max-w-7xl mx-auto px-6 py-12">
                    <div className="text-center mb-16">
                        <h2 className="text-5xl font-bold text-gray-900 dark:text-white mb-6">
                            💊 Complete Pharmacy
                            <br />
                            <span className="bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                                Management System
                            </span>
                        </h2>
                        <p className="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                            Streamline your pharmacy operations with comprehensive inventory management, 
                            sales tracking, customer data, prescription handling, and financial reporting.
                        </p>
                        {!auth.user && (
                            <div className="flex justify-center space-x-4">
                                <Link
                                    href={route('register')}
                                    className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-medium transition-colors"
                                >
                                    Start Free Trial 🚀
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="border-2 border-blue-600 text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-lg text-lg font-medium transition-colors"
                                >
                                    Sign In
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Features Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                        {/* Sales Management */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-2xl">💰</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Sales Management</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2 text-sm">
                                <li>• General & prescription sales</li>
                                <li>• Cost-plus-markup pricing</li>
                                <li>• Multi-unit & partner pricing</li>
                                <li>• Credit sales with limits</li>
                                <li>• Sales returns & refunds</li>
                            </ul>
                        </div>

                        {/* Inventory Control */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-2xl">📦</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Inventory Control</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2 text-sm">
                                <li>• Real-time stock tracking</li>
                                <li>• Batch & expiry date management</li>
                                <li>• Stock transfers (in/out)</li>
                                <li>• Low stock alerts</li>
                                <li>• Stock opname & updates</li>
                            </ul>
                        </div>

                        {/* Customer Management */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-2xl">👥</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Customer Management</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2 text-sm">
                                <li>• Customer profiles & history</li>
                                <li>• Credit limit management</li>
                                <li>• Prescription tracking</li>
                                <li>• Purchase history</li>
                                <li>• Loyalty programs</li>
                            </ul>
                        </div>

                        {/* Purchase Management */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-2xl">🛒</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Purchase Management</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2 text-sm">
                                <li>• Purchase invoice recording</li>
                                <li>• Supplier management</li>
                                <li>• Price updates & tracking</li>
                                <li>• Invoice settlements</li>
                                <li>• Purchase data downloads</li>
                            </ul>
                        </div>

                        {/* Financial Management */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-2xl">📊</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Financial Management</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2 text-sm">
                                <li>• Digital cash book</li>
                                <li>• Revenue & expense tracking</li>
                                <li>• Profit margin analysis</li>
                                <li>• Payment method tracking</li>
                                <li>• Financial reports</li>
                            </ul>
                        </div>

                        {/* Advanced Features */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-2xl">⚡</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Advanced Features</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2 text-sm">
                                <li>• User & employee shift management</li>
                                <li>• Virtual account payments</li>
                                <li>• Order management system</li>
                                <li>• Invoice adjustments</li>
                                <li>• Comprehensive reporting</li>
                            </ul>
                        </div>
                    </div>

                    {/* Demo Screenshots */}
                    <div className="text-center mb-16">
                        <h3 className="text-3xl font-bold text-gray-900 dark:text-white mb-8">See It In Action</h3>
                        <div className="grid md:grid-cols-2 gap-8">
                            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                                <div className="w-full h-48 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 rounded-lg flex items-center justify-center mb-4">
                                    <div className="text-center">
                                        <div className="text-4xl mb-2">📈</div>
                                        <p className="text-blue-700 dark:text-blue-300">Sales Dashboard</p>
                                    </div>
                                </div>
                                <h4 className="font-semibold text-gray-900 dark:text-white mb-2">Real-time Analytics</h4>
                                <p className="text-gray-600 dark:text-gray-300 text-sm">Track sales, inventory, and performance metrics with beautiful charts and insights.</p>
                            </div>
                            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                                <div className="w-full h-48 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900 dark:to-green-800 rounded-lg flex items-center justify-center mb-4">
                                    <div className="text-center">
                                        <div className="text-4xl mb-2">🎯</div>
                                        <p className="text-green-700 dark:text-green-300">Inventory Management</p>
                                    </div>
                                </div>
                                <h4 className="font-semibold text-gray-900 dark:text-white mb-2">Smart Inventory</h4>
                                <p className="text-gray-600 dark:text-gray-300 text-sm">Automated stock alerts, expiry tracking, and batch management for optimal inventory control.</p>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    {!auth.user && (
                        <div className="bg-gradient-to-r from-blue-600 to-green-600 rounded-2xl p-8 text-center text-white">
                            <h3 className="text-3xl font-bold mb-4">Ready to Transform Your Pharmacy? 🚀</h3>
                            <p className="text-xl mb-6 opacity-90">
                                Join thousands of pharmacies already using PharmaCare Pro to streamline their operations.
                            </p>
                            <div className="flex justify-center space-x-4">
                                <Link
                                    href={route('register')}
                                    className="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-medium transition-colors"
                                >
                                    Start Free Trial
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-lg text-lg font-medium transition-colors"
                                >
                                    Sign In
                                </Link>
                            </div>
                        </div>
                    )}
                </main>

                {/* Footer */}
                <footer className="max-w-7xl mx-auto px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                    <p>Built with ❤️ for modern pharmacies • Secure • Reliable • Professional</p>
                </footer>
            </div>
        </>
    );
}