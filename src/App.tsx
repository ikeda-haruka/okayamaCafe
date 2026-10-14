import React, { useEffect } from 'react';
import { BrowserRouter, Routes, Route, useLocation } from 'react-router-dom';
import { Navbar } from './components/Navbar';
import { Footer } from './components/Footer';
import { BottomBar } from './components/BottomBar';
import { HomePage } from './pages/HomePage';
import { AboutPage } from './pages/AboutPage';
import { MenuPage } from './pages/MenuPage';
import { FruitsPage } from './pages/FruitsPage';
import { AccessPage } from './pages/AccessPage';
import { ContactPage } from './pages/ContactPage';
import { NewsPage } from './pages/NewsPage';

// ページ遷移時にスクロールを最上部に移動させるコンポーネント
const ScrollToTop: React.FC = () => {
  const { pathname } = useLocation();

  useEffect(() => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }, [pathname]);

  return null;
};

export function App() {
  return (
    <BrowserRouter>
      <ScrollToTop />
      <div className="min-h-screen flex flex-col bg-[#faf7f2] text-[#433932]">
        <Navbar />
        <main className="flex-1">
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/about" element={<AboutPage />} />
            <Route path="/menu" element={<MenuPage />} />
            <Route path="/fruits" element={<FruitsPage />} />
            <Route path="/news" element={<NewsPage />} />
            <Route path="/access" element={<AccessPage />} />
            <Route path="/contact" element={<ContactPage />} />
          </Routes>
        </main>
        <Footer />
        <BottomBar />
      </div>
    </BrowserRouter>
  );
}

export default App;
