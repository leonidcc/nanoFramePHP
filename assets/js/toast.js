// toastify.js

class Toastify {
    constructor() {
      this.container = document.createElement('div');
      this.container.className = 'toastify-container';
      document.body.appendChild(this.container);
    }
  
    show(message, type) {
      const toast = document.createElement('div');
      toast.className = `toastify-toast ${type}`;
      toast.innerHTML = `
        <div class="toastify-message">${message}
        <span   onclick="Toastify.closeToast(this.parentNode.parentNode)">
          <i class="bi bi-x-lg"></i>
        </span>
        </div>
        
      `;
  
      this.container.appendChild(toast);
  
      setTimeout(() => {
        this.closeToast(toast);
      }, 5000); // Tiempo en milisegundos para que el toast desaparezca automáticamente
    }
  
    success(message) {
      this.show(message, 'success');
    }
      
    info(message) {
      this.show(message, 'info');
    }
  
    warning(message) {
      this.show(message, 'warning');
    }
  
    error(message) {
      this.show(message, 'error');
    }
  
    closeToast(toastElement) {
      toastElement.style.animation = 'fade-out 0.5s forwards';
      setTimeout(() => {
        try {
          this.container.removeChild(toastElement);  
        } catch (error) {
          console.log("deleted");
        }
        
      }, 500);
    }
  
    static closeToast(toastElement) {
      const toastifyInstance = new Toastify();
      toastifyInstance.closeToast(toastElement);
    }
  }
  
  // Estilos CSS (Estos estilos son solo ejemplos, puedes personalizarlos según tus necesidades)
  // Puedes agregar estos estilos en tu archivo CSS o directamente en tu archivo JS utilizando una plantilla de cadena
  
  const styles = `
    .toastify-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
    }
  
    .toastify-toast {
      background: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 15px;
      opacity: 0;
      animation: fade-in 0.5s forwards;
    }
  
    .success {
      border-left: 5px solid #28a745;
    }
  
    .warning {
      border-left: 5px solid #ffc107;
    }

    .info {
      border-left: 5px solid #4798EC;
    }
  
    .error {
      border-left: 5px solid #dc3545;
    }
  
   
  
    .toastify-close-btn {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      transition: background 0.3s;
    }
  
    .toastify-close-btn:hover {
      background: #0056b3;
    }
  
    @keyframes fade-in {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  
    @keyframes fade-out {
      to {
        opacity: 0;
        transform: translateY(-20px);
      }
    }
  `;
  
  // Agrega los estilos al head del documento
  const styleElement = document.createElement('style');
  styleElement.innerHTML = styles;
  document.head.appendChild(styleElement);
  
  // Ejemplo de uso
  const toastify = new Toastify();
  