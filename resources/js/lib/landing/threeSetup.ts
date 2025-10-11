import * as THREE from 'three';

export function createParticleScene(container: HTMLElement, isMobile: boolean) {
    // Scene setup
    const scene = new THREE.Scene();

    const width = container.clientWidth;
    const height = container.clientHeight;

    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    camera.position.z = isMobile ? 350 : 250;

    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    container.appendChild(renderer.domElement);

    // Particle system
    const particleCount = isMobile ? 1000 : 2000;
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);
    const sizes = new Float32Array(particleCount);

    // Color distributions (HSL converted to RGB)
    const colorPalette = [
        { color: new THREE.Color('hsl(0, 70%, 55%)'), weight: 0.7 },    // Red
        { color: new THREE.Color('hsl(45, 90%, 60%)'), weight: 0.25 },  // Yellow
        { color: new THREE.Color('hsl(142, 60%, 50%)'), weight: 0.05 }, // Green
    ];

    let colorIndex = 0;
    for (let i = 0; i < particleCount; i++) {
        // Position in a sphere
        const radius = 100 + Math.random() * 100;
        const theta = Math.random() * Math.PI * 2;
        const phi = Math.acos(2 * Math.random() - 1);

        positions[i * 3] = radius * Math.sin(phi) * Math.cos(theta);
        positions[i * 3 + 1] = radius * Math.sin(phi) * Math.sin(theta);
        positions[i * 3 + 2] = radius * Math.cos(phi);

        // Assign color based on distribution
        const rand = Math.random();
        let accumulated = 0;
        let selectedColor = colorPalette[0].color;

        for (const { color, weight } of colorPalette) {
            accumulated += weight;
            if (rand <= accumulated) {
                selectedColor = color;
                break;
            }
        }

        colors[i * 3] = selectedColor.r;
        colors[i * 3 + 1] = selectedColor.g;
        colors[i * 3 + 2] = selectedColor.b;

        // Size
        sizes[i] = Math.random() * 3 + 1;
    }

    const geometry = new THREE.BufferGeometry();
    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
    geometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

    const material = new THREE.PointsMaterial({
        size: isMobile ? 2 : 3,
        vertexColors: true,
        transparent: true,
        opacity: 0.8,
        sizeAttenuation: true,
    });

    const particles = new THREE.Points(geometry, material);
    scene.add(particles);

    // Mouse interaction
    const mouse = { x: 0, y: 0 };
    let targetRotation = { x: 0, y: 0 };

    function onMouseMove(event: MouseEvent) {
        mouse.x = (event.clientX / width) * 2 - 1;
        mouse.y = -(event.clientY / height) * 2 + 1;

        targetRotation.y = mouse.x * 0.3;
        targetRotation.x = mouse.y * 0.3;
    }

    container.addEventListener('mousemove', onMouseMove);

    // Animation
    const clock = new THREE.Clock();
    let animationId: number;

    function animate() {
        animationId = requestAnimationFrame(animate);

        const elapsedTime = clock.getElapsedTime();

        // Smooth rotation
        particles.rotation.y += (targetRotation.y - particles.rotation.y) * 0.05;
        particles.rotation.x += (targetRotation.x - particles.rotation.x) * 0.05;

        // Add subtle auto-rotation
        particles.rotation.y += 0.001;

        // Particle wave effect
        const positionsAttr = particles.geometry.attributes.position as THREE.BufferAttribute;
        const originalPositions = positionsAttr.array;

        for (let i = 0; i < particleCount; i++) {
            const i3 = i * 3;
            const x = originalPositions[i3];
            const y = originalPositions[i3 + 1];
            const z = originalPositions[i3 + 2];

            // Subtle pulse
            const distance = Math.sqrt(x * x + y * y + z * z);
            const pulse = Math.sin(elapsedTime * 0.5 + distance * 0.01) * 2;

            positionsAttr.array[i3] = x + pulse * (x / distance);
            positionsAttr.array[i3 + 1] = y + pulse * (y / distance);
            positionsAttr.array[i3 + 2] = z + pulse * (z / distance);
        }

        positionsAttr.needsUpdate = true;

        renderer.render(scene, camera);
    }

    animate();

    // Cleanup
    return {
        cleanup: () => {
            cancelAnimationFrame(animationId);
            container.removeEventListener('mousemove', onMouseMove);
            geometry.dispose();
            material.dispose();
            renderer.dispose();
            container.removeChild(renderer.domElement);
        },
        resize: () => {
            const newWidth = container.clientWidth;
            const newHeight = container.clientHeight;

            camera.aspect = newWidth / newHeight;
            camera.updateProjectionMatrix();

            renderer.setSize(newWidth, newHeight);
        },
    };
}
