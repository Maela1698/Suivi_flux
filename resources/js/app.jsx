import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import HelloReact from './components/HelloReact';

const rootElement = document.getElementById('app');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<HelloReact />);
}
