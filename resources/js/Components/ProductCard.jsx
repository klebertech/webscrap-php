import React from 'react'

function ProductCard({description, category, website, price, link, image}) {
  return (
    <div className="card w-96 bg-base-100 shadow-xl my-4">
    <figure><img src={image} alt={description} /></figure>
    <div className="card-body">
        <div className="badge badge-accent">{website}</div>
        <p>Categoria: {category}</p>
        <h3 className="card-title">{description}</h3>
        <div className="stat">
            <div className="stat-value">R$ {price}</div>
            <div className="stat-actions">
            <a href={`${link}`} target='_blank'>
                <button className="btn btn-sm btn-success">Comprar</button>
            </a>
            </div>
        </div>
    </div>
    </div>
  )
}

export default ProductCard
