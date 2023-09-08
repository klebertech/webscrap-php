import React from 'react';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import { useForm } from '@inertiajs/react';
import ProductCard from '@/Components/ProductCard';

export default function SearchForm({products}) {
    const { data, setData, post, processing, reset, errors } = useForm({
        searchWord: '',
        category: 'tv',
        website: 'All'
    });
    console.log(products);
    const submit = (e) => {
        e.preventDefault();
        post(route('search.store'), { onSuccess: () => reset() });
    };

    return (
      <>
        <div className='flex flex-col gap-2 max-w-full'>
          <div className="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 w-full">
            <form onSubmit={submit}>
              <div className='flex flex-row gap-4 pb-4'>
                <select
                  className="select select-bordered w-full max-w-xs"
                  value={data.website}
                  onChange={e => setData('website', e.target.value)}
                >
                  <option value='All'>Web</option>
                  <option value='MercadoLivre'>MercadoLivre</option>
                  <option value='Buscape'>Buscape</option>
                </select>
                <select
                  className="select select-bordered w-full max-w-xs"
                  value={data.category}
                  onChange={e => setData('category', e.target.value)}
                >
                  <option value='tv'>TV</option>
                  <option value='geladeira'>Geladeira</option>
                  <option value='celular'>Celular</option>
                </select>
              </div>
              <textarea
                  value={data.searchWord}
                  placeholder="O que está procurando?"
                  className="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                  onChange={e => setData('searchWord', e.target.value)}
              ></textarea>
              <InputError message={errors.searchWord} className="mt-2" />
              <PrimaryButton className="mt-4" disabled={processing}>Buscar</PrimaryButton>
            </form>
          </div>
          <div className="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
          {products?.map((element, index) =>(
            <ProductCard
                key={index}
                description={element.description}
                category={element.category}
                website={element.website}
                image={element.photo}
                link={element.link}
                price={element.price}
              />
          ))}
          </div>
        </div>
      </>
    );
}
