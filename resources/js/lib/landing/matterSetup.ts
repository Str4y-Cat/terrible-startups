import Matter from 'matter-js';

export interface CardData {
    label: string;
    size: 'small' | 'medium' | 'large';
}

export const terribleIdeas = [
    'Blockchain for Houseplants',
    'AI-Powered Socks',
    'Uber for Lost Keys',
    'Netflix for Dreams',
    'Tinder for Furniture',
    'Airbnb for Bathrooms',
    'Instagram for Ants',
    'Pet Rock 2.0',
];

// Card size configurations
const cardSizes = {
    small: { width: 80, height: 50 },
    medium: { width: 120, height: 75 },
    large: { width: 160, height: 100 },
};

export function createBallPitWorld(canvas: HTMLCanvasElement, isMobile: boolean) {
    const Engine = Matter.Engine;
    const Render = Matter.Render;
    const World = Matter.World;
    const Bodies = Matter.Bodies;
    const Mouse = Matter.Mouse;
    const MouseConstraint = Matter.MouseConstraint;

    // Create engine with reduced gravity for floaty feel
    const engine = Engine.create();
    engine.gravity.y = 0.5;

    // Create renderer with custom rendering disabled (we'll draw manually)
    const render = Render.create({
        canvas: canvas,
        engine: engine,
        options: {
            width: canvas.clientWidth,
            height: canvas.clientHeight,
            wireframes: false,
            background: 'transparent',
        },
    });

    // Create walls
    const wallOptions = { isStatic: true, render: { fillStyle: 'transparent' } };
    const walls = [
        Bodies.rectangle(canvas.clientWidth / 2, 0, canvas.clientWidth, 20, wallOptions), // top
        Bodies.rectangle(canvas.clientWidth / 2, canvas.clientHeight, canvas.clientWidth, 20, wallOptions), // bottom
        Bodies.rectangle(0, canvas.clientHeight / 2, 20, canvas.clientHeight, wallOptions), // left
        Bodies.rectangle(canvas.clientWidth, canvas.clientHeight / 2, 20, canvas.clientHeight, wallOptions), // right
    ];

    // Create cards with varying sizes
    const totalCards = isMobile ? 12 : 20;
    const cards: Matter.Body[] = [];
    const cardData = new Map<Matter.Body, CardData>();

    // Size distribution: 40% small, 40% medium, 20% large
    const sizeDistribution = [
        { size: 'small' as const, count: Math.floor(totalCards * 0.4) },
        { size: 'medium' as const, count: Math.floor(totalCards * 0.4) },
        { size: 'large' as const, count: totalCards - Math.floor(totalCards * 0.4) - Math.floor(totalCards * 0.4) },
    ];

    let ideaIndex = 0;
    sizeDistribution.forEach(({ size, count }) => {
        for (let i = 0; i < count; i++) {
            const dimensions = cardSizes[size];
            const x = Math.random() * (canvas.clientWidth - dimensions.width) + dimensions.width / 2;
            const y = Math.random() * (canvas.clientHeight - dimensions.height) + dimensions.height / 2;

            const card = Bodies.rectangle(x, y, dimensions.width, dimensions.height, {
                restitution: 0.5,
                friction: 0.05,
                density: 0.001,
                angle: (Math.random() - 0.5) * 0.3, // Slight random rotation
                render: {
                    fillStyle: 'transparent', // We'll render manually
                },
            });

            cards.push(card);
            cardData.set(card, {
                label: terribleIdeas[ideaIndex % terribleIdeas.length],
                size: size,
            });
            ideaIndex++;
        }
    });

    // Add all bodies to world
    World.add(engine.world, [...walls, ...cards]);

    // Add mouse control
    const mouse = Mouse.create(render.canvas);
    const mouseConstraint = MouseConstraint.create(engine, {
        mouse: mouse,
        constraint: {
            stiffness: 0.2,
            render: {
                visible: false,
            },
        },
    });

    World.add(engine.world, mouseConstraint);

    // Keep the mouse in sync with rendering
    render.mouse = mouse;

    // Custom rendering function for cards
    const ctx = canvas.getContext('2d');
    if (!ctx) throw new Error('Could not get canvas context');

    // Get computed styles from document for Tailwind colors
    const rootStyles = getComputedStyle(document.documentElement);
    const cardBg = rootStyles.getPropertyValue('--card').trim() || '0 0% 100%';
    const cardBorder = rootStyles.getPropertyValue('--border').trim() || '0 0% 89.8%';
    const cardText = rootStyles.getPropertyValue('--card-foreground').trim() || '0 0% 3.9%';

    // Convert HSL to RGB for canvas
    const hslToRgb = (h: number, s: number, l: number) => {
        s /= 100;
        l /= 100;
        const k = (n: number) => (n + h / 30) % 12;
        const a = s * Math.min(l, 1 - l);
        const f = (n: number) => l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1)));
        return [Math.round(255 * f(0)), Math.round(255 * f(8)), Math.round(255 * f(4))];
    };

    const parseHsl = (hsl: string) => {
        const values = hsl.split(' ').map(v => parseFloat(v));
        return { h: values[0] || 0, s: values[1] || 0, l: values[2] || 100 };
    };

    // Run the engine
    const runner = Matter.Runner.create();
    Matter.Runner.run(runner, engine);

    // Custom render loop
    function customRender() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        cards.forEach((card) => {
            const data = cardData.get(card);
            if (!data) return;

            const dimensions = cardSizes[data.size];
            ctx.save();

            // Translate to card position and rotate
            ctx.translate(card.position.x, card.position.y);
            ctx.rotate(card.angle);

            // Draw card background
            ctx.fillStyle = `hsl(${cardBg})`;
            ctx.strokeStyle = `hsl(${cardBorder})`;
            ctx.lineWidth = 1;

            const radius = 8;
            const x = -dimensions.width / 2;
            const y = -dimensions.height / 2;

            // Rounded rectangle
            ctx.beginPath();
            ctx.moveTo(x + radius, y);
            ctx.lineTo(x + dimensions.width - radius, y);
            ctx.quadraticCurveTo(x + dimensions.width, y, x + dimensions.width, y + radius);
            ctx.lineTo(x + dimensions.width, y + dimensions.height - radius);
            ctx.quadraticCurveTo(x + dimensions.width, y + dimensions.height, x + dimensions.width - radius, y + dimensions.height);
            ctx.lineTo(x + radius, y + dimensions.height);
            ctx.quadraticCurveTo(x, y + dimensions.height, x, y + dimensions.height - radius);
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();

            ctx.fill();
            ctx.stroke();

            // Add shadow
            ctx.shadowColor = 'rgba(0, 0, 0, 0.1)';
            ctx.shadowBlur = 4;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 2;

            // Draw text
            ctx.fillStyle = `hsl(${cardText})`;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.shadowColor = 'transparent';

            const fontSize = data.size === 'small' ? 10 : data.size === 'medium' ? 12 : 14;
            ctx.font = `600 ${fontSize}px Inter, system-ui, sans-serif`;

            // Word wrap text
            const words = data.label.split(' ');
            const maxWidth = dimensions.width - 16;
            const lines: string[] = [];
            let currentLine = words[0];

            for (let i = 1; i < words.length; i++) {
                const testLine = currentLine + ' ' + words[i];
                const metrics = ctx.measureText(testLine);
                if (metrics.width > maxWidth) {
                    lines.push(currentLine);
                    currentLine = words[i];
                } else {
                    currentLine = testLine;
                }
            }
            lines.push(currentLine);

            const lineHeight = fontSize * 1.3;
            const totalHeight = lines.length * lineHeight;
            const startY = -totalHeight / 2 + lineHeight / 2;

            lines.forEach((line, i) => {
                ctx.fillText(line, 0, startY + i * lineHeight);
            });

            ctx.restore();
        });

        requestAnimationFrame(customRender);
    }

    customRender();

    return {
        engine,
        render,
        runner,
        balls: cards,
        ballData: cardData,
        cleanup: () => {
            Matter.Runner.stop(runner);
            Render.stop(render);
            World.clear(engine.world, false);
            Engine.clear(engine);
        },
    };
}

export function handleResize(
    canvas: HTMLCanvasElement,
    render: Matter.Render,
    engine: Matter.Engine
) {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;

    // Update canvas
    canvas.width = width;
    canvas.height = height;

    // Update render bounds
    render.bounds.max.x = width;
    render.bounds.max.y = height;
    render.options.width = width;
    render.options.height = height;
    render.canvas.width = width;
    render.canvas.height = height;

    // Update walls
    const walls = engine.world.bodies.filter((body) => body.isStatic);
    if (walls.length >= 4) {
        Matter.Body.setPosition(walls[0], { x: width / 2, y: 0 });
        Matter.Body.setPosition(walls[1], { x: width / 2, y: height });
        Matter.Body.setPosition(walls[2], { x: 0, y: height / 2 });
        Matter.Body.setPosition(walls[3], { x: width, y: height / 2 });
    }
}
